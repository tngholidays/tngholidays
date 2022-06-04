<?php
namespace Modules\Report\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Booking\Emails\NewBookingEmail;
use Modules\Booking\Emails\VoucherEmail;
use Modules\Booking\Events\BookingUpdatedEvent;
use Modules\Booking\Models\Booking;

    use Modules\Core\Events\CreatedServicesEvent;
    use Modules\Core\Events\UpdatedServiceEvent;
    use Modules\Core\Models\Attributes;
    use Modules\Location\Models\LocationCategory;
    use Modules\Tour\Models\Tour;
    use Modules\Tour\Models\ManageItinerary;
    use Modules\Tour\Models\ManageVoucher;
    use Modules\Core\Models\Terms;
    use Modules\Booking\Models\BookingProposal;
        use Propaganistas\LaravelPhone\PhoneNumber;
  use Modules\Sms\Core\Facade\Sms;
  use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use PDF;
    use Mail;
    use File;
    use Swift_SmtpTransport;
    use Swift_Mailer;
    use DB;

class BookingController extends AdminController
{
    protected $tourClass;
    protected $manageItineraryClass;
    protected $manageVoucherClass;

        /**
         * @var string
         */
        private $locationCategoryClass;

    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu('admin/module/report/booking');
        $this->tourClass = Tour::class;
        $this->manageItineraryClass = ManageItinerary::class;
        $this->manageVoucherClass = ManageVoucher::class;
    }

    public function index(Request $request)
    {
        $this->checkPermission('booking_view');
        $query = Booking::where('status', '!=', 'draft');
        if (!empty($request->s)) {
            if( is_numeric($request->s) ){
                $query->Where('id', '=', $request->s);
            }else{
                $query->where(function ($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->s . '%')
                        ->orWhere('last_name', 'like', '%' . $request->s . '%')
                        ->orWhere('email', 'like', '%' . $request->s . '%')
                        ->orWhere('phone', 'like', '%' . $request->s . '%')
                        ->orWhere('address', 'like', '%' . $request->s . '%')
                        ->orWhere('address2', 'like', '%' . $request->s . '%');
                });
            }
        }
        if ($this->hasPermission('booking_manage_others')) {
            if (!empty($request->vendor_id)) {
                $query->where('vendor_id', $request->vendor_id);
            }
        } else {
            $query->where('vendor_id', Auth::id());
        }
        $query->whereIn('object_model', array_keys(get_bookable_services()));
        $query->orderBy('id','desc');
        $data = [
            'rows'                  => $query->paginate(20),
            'page_title'            => __("All Bookings"),
            'booking_manage_others' => $this->hasPermission('booking_manage_others'),
            'booking_update'        => $this->hasPermission('booking_update'),
            'statues'               => config('booking.statuses')
        ];
        return view('Report::admin.booking.index', $data);
    }

    public function bulkEdit(Request $request)
    {
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected'));
        }
        if (empty($action)) {
            return redirect()->back()->with('error', __('Please select action'));
        }
        if ($action == "delete") {
            foreach ($ids as $id) {
                $query = Booking::where("id", $id);
                if (!$this->hasPermission('booking_manage_others')) {
                    $query->where("vendor_id", Auth::id());
                }
                $row = $query->first();
                if(!empty($row)){
                    $row->delete();
                    event(new BookingUpdatedEvent($row));

                }
            }
        } else {
            foreach ($ids as $id) {
                $query = Booking::where("id", $id);
                if (!$this->hasPermission('booking_manage_others')) {
                    $query->where("vendor_id", Auth::id());
                    $this->checkPermission('booking_update');
                }
                $item = $query->first();
                if(!empty($item)){
                    $item->status = $action;
                    $item->save();

                    if($action == Booking::CANCELLED) $item->tryRefundToWallet();
                    event(new BookingUpdatedEvent($item));
                }
            }
        }
        return redirect()->back()->with('success', __('Update success'));
    }

    public function email_preview(Request $request, $id)
    {
        $booking = Booking::find($id);
        return (new NewBookingEmail($booking))->render();
    }
    public function invoice_preview(Request $request, $id)
    {
        $booking = Booking::find($id);
        $user_id = Auth::id();
        $data = [
            'booking'    => $booking,
            'service'    => $booking->service,
            'page_title' => __("Invoice")
        ];
        return view('User::frontend.bookingInvoice', $data);
    }
    public function ticket_preview(Request $request, $id)
    {
        $booking = Booking::find($id);
        $user_id = Auth::id();
        $data = [
            'booking'    => $booking,
            'service'    => $booking->service,
            'page_title' => __("Invoice")
        ];
        return view('User::frontend.booking.ticket', $data);
    }
    public function manage_itinerary(Request $request, $id)
    {
            $booking = Booking::find($id);
            
            $BookingProposal = BookingProposal::select('tour_details')->where("id", $booking->proposal_id)->first();
            if (!empty($BookingProposal) && !empty($BookingProposal->tour_details)) {
                $tour = margeCustomTour($booking->object_id, $BookingProposal->tour_details);
            }else{
                $tour = $this->tourClass::find($booking->object_id);
            }

            $row = $this->manageItineraryClass::where('booking_id', $id)->first();
            if (empty($row)) {
                $row = new ManageItinerary();
                $row->fill([
                    'status' => 'publish'
                ]);
            }
            $data = [
                'row'               => $row,
                'tour'              => $tour,
                'booking'           => $booking,
                'page_title'            => __("Manage Itinerary"),
                'breadcrumbs'       => [
                    [
                        'name' => __('Report'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name' => __('Booking'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name'  => __('Manage Itinerary'),
                        'class' => 'active'
                    ],
                ]
            ];
         return view('Report::admin.booking.manage-itinerary', $data);
    }
    public function storeItinerary(Request $request, $id)
        {
            if ($id > 0) {
                $row = $this->manageItineraryClass::find($id);
                if (empty($row)) {
                    return redirect(route('tour.admin.index'));
                }
                if ($row->create_user != Auth::id() and !$this->hasPermission('tour_manage_others')) {
                    return redirect(route('tour.admin.index'));
                }

            } else {
                $row = new $this->manageItineraryClass();
                $row->status = "publish";
            }
            // dd($row);
            $row->fill($request->input());
            $row->save();
            if ($row) {
                if ($id > 0) {
                    event(new UpdatedServiceEvent($row));

                    return back()->with('success', __('Tour Itinerary updated'));
                } else {
                    event(new CreatedServicesEvent($row));

                    return redirect(route('report.booking.manage_itinerary', $row->booking_id))->with('success', __('Tour Itinerary created'));
                }
            }
        }
    public function manage_voucher(Request $request, $id)
    {
            $booking = Booking::find($id);
            $row = $this->manageVoucherClass::with('term')->where('booking_id', $id)->get();
            $term_ids = $this->manageVoucherClass::with('term')->where('booking_id', $id)->pluck('term_id')->toArray();
            $manageItinerary = $this->manageItineraryClass::where('booking_id', $id)->first();
            $data = [
                'rows'              => $row,
                'term_ids'          => $term_ids,
                'booking'           => $booking,
                'manageItinerary'   => $manageItinerary->itinerary,
                'page_title'            => __("Manage Voucher"),
                'breadcrumbs'       => [
                    [
                        'name' => __('Report'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name' => __('Booking'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name'  => __('Manage Voucher'),
                        'class' => 'active'
                    ],
                ]
            ];
        return view('Report::admin.booking.manage-voucher', $data);
    }
    public function mail_voucher(Request $request, $id)
    {
            $row = $this->manageVoucherClass::find($id);
            $booking = Booking::find($row->booking_id);
            $service = $booking->service;
            $mailInfo=DB::table('mail_settings')->get();
            $data = [
                'row'              => $row,
                'booking'           => $booking,
                'service'    => $service,
                'mailInfo'    => $mailInfo,
                'page_title'   => __("Mail Voucher"),
                'breadcrumbs'       => [
                    [
                        'name' => __('Report'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name' => __('Booking'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name' => __('Manage Voucher'),
                        'url'  => 'admin/module/report/booking/manage_voucher/'.$row->booking_id,
                    ],
                    [
                        'name'  => __('Mail Voucher'),
                        'class' => 'active'
                    ],
                ]
            ];

            $pdf = PDF::loadView('Report::admin.booking.voucherPDF',compact('row','service','booking'));
            $output = $pdf->output();
             $path = public_path().'/voucher/voucher.pdf';
             file_put_contents($path, $output);
            // return $pdf->stream('voucherPDF.pdf',array('Attachment'=>0));
        return view('Report::admin.booking.mail-voucher', $data);
    }
    public function mail_ticket(Request $request, $id)
    {
            $booking = Booking::find($id);
            $service = $booking->service;
            $mailInfo=DB::table('mail_settings')->get();
            $data = [
                'booking'           => $booking,
                'service'    => $service,
                'mailInfo'    => $mailInfo,
                'page_title'   => __("Mail Ticket"),
                'breadcrumbs'       => [
                    [
                        'name' => __('Report'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name' => __('Booking'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name'  => __('Mail Ticket'),
                        'class' => 'active'
                    ],
                ]
            ];

            $qrcode = QrCode::format('svg')->size(200)->errorCorrection('H')->generate($booking->id.'.'.\Illuminate\Support\Facades\Hash::make($booking->id));
            $pdf = PDF::loadView('User::frontend.booking.ticketPDF',compact('service','booking','qrcode'));

            $output = $pdf->output();
             $path = public_path().'/voucher/ticketPDF.pdf';
             file_put_contents($path, $output);


        return view('Report::admin.booking.mail-ticket', $data);
    }

    public function send_ticket_mail(Request $request, $id)
    {

            $booking = Booking::find($id);
            $service = $booking->service;
            $emails = $service->emails;
            $qrcode = QrCode::format('svg')->size(200)->errorCorrection('H')->generate($booking->id.'.'.\Illuminate\Support\Facades\Hash::make($booking->id));
            $pdf = PDF::loadView('User::frontend.booking.ticketPDF',compact('service','booking','qrcode'));
            $from = $request->input('from');
            $mailInfo=DB::table('mail_settings')->Where('id', $from)->first();
            $output = $pdf->output();
            $data = [
                'booking'           => $booking,
                'service'           => $service,
                'from'    => $mailInfo->username,
                'pdf'    => $output
            ];
            
            $backup = Mail::getSwiftMailer();
            $transport = new Swift_SmtpTransport($mailInfo->host, 465, 'ssl');
            $transport->setUsername($mailInfo->username);
            $transport->setPassword($mailInfo->password);
            // Any other mailer configuration stuff needed...
            $gmail = new Swift_Mailer($transport);
            // Set the mailer as gmail
            Mail::setSwiftMailer($gmail);
            $sub = "Confirmation For Activity";
            if (!empty($emails) && count($emails) > 0) {
                foreach ($emails as $key => $toEmail) {
                    try{
                       Mail::send('Booking::emails.mail-ticket', $data, function( $message ) use ($data, $toEmail, $sub)
                       {
                          $message->to($toEmail)->from($data['from'])->subject($sub);
                          $message->attachData($data['pdf'], 'voucher.pdf');
                        });
                    }
                    catch(\Exception $e){
                        // dd($e);
                    }
                }
            }
          return back()->with('success', __('Mail Sent'));
    }
    public function send_mail(Request $request, $id)
    {
            $row = $this->manageVoucherClass::find($id);
            $booking = Booking::find($row->booking_id);
            $service = $booking->service;
             
            $pdf = PDF::loadView('Report::admin.booking.voucherPDF',compact('row','service','booking'));
            $from = $request->input('from');
            $mailInfo=DB::table('mail_settings')->Where('id', $from)->first();
            $output = $pdf->output();
            $data = [
                'row'              => $row,
                'booking'           => $booking,
                'from'    => $mailInfo->username,
                'pdf'    => $output,
                'type'    => $row->voucher_type,
            ];
            
            $backup = Mail::getSwiftMailer();
            $transport = new Swift_SmtpTransport($mailInfo->host, 465, 'ssl');
            $transport->setUsername($mailInfo->username);
            $transport->setPassword($mailInfo->password);
            // Any other mailer configuration stuff needed...
            $gmail = new Swift_Mailer($transport);
            // Set the mailer as gmail
            Mail::setSwiftMailer($gmail);

            // return view('Booking::emails.mail-voucher', $data);
            
            if ($row->voucher_type == 3) {
              $hotelDDetail = getHotelById($row->term_id);
              $emails = $hotelDDetail->emails;
              $sub = "Hotel";
            }
            else if ($row->voucher_type == 4) {
              
              $emails = [];
              $sub = "Transportation";
            }else {
              $emails = $row->term->emails;
              $sub = "Voucher";
            }
            // return view('Booking::emails.mail-voucher', $data);
            if (count($emails) > 0) {
                foreach ($emails as $key => $toEmail) {
                    try{
                       Mail::send('Booking::emails.mail-voucher', $data, function( $message ) use ($data, $toEmail, $sub)
                       {
                          $message->to($toEmail)->from($data['from'])->subject($sub);
                          if ($data['type'] != 3) {
                            $message->attachData($data['pdf'], 'voucher.pdf');
                          }
                        });
                    }
                    catch(\Exception $e){
                        dd($e);
                    }
                }
            }
            if ($row->voucher_type == 4) {
               $name =  (!empty($row->name) ? $row->name : $booking->first_name.' '.$booking->last_name);
               
               $person_types = $row->person_types;
               $persons = 0;
               if(count($person_types) > 0){
                   foreach ($person_types as $key => $type) {
                       $persons += $type['no_of_pax'];
                   }
               }else{
                   $persons += $booking->total_guests;
               }
              $message = $msg = 'Booking Number: '.$row->booking_id.'%0a Lead Person Name: '.$name.'%0a No. of Person: '.$persons.'%0a Hotel Name: '.$row->hotel_name.'%0a Package: '.$row->package_details.'%0a Date: '.@$row->date.'%0a Time: '.@$row->time;
              $to = (string)PhoneNumber::make($request->input('phone'))->ofCountry('IN');
              Sms::to($to)->content($message)->send();
            }
            $row->mail_status = 1;
            $row->save();
          return back()->with('success', __('Mail Sent'));
    }
    public function edit_voucher(Request $request, $id)
    {
            $row = $this->manageVoucherClass::find($id);
            $booking = Booking::find($row->booking_id);
            $term_ids = $this->manageVoucherClass::with('term')->where('booking_id', $row->booking_id)->pluck('term_id')->toArray();
             $manageItinerary = $this->manageItineraryClass::where('booking_id', $row->booking_id)->first();
            $data = [
                'row'              => $row,
                'term_ids'          => $term_ids,
                'manageItinerary'   => $manageItinerary->itinerary,
                'booking'           => $booking,
                'page_title'            => __("Edit Voucher"),
                'breadcrumbs'       => [
                    [
                        'name' => __('Report'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name' => __('Booking'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name' => __('Manage Voucher'),
                        'url'  => 'admin/module/report/booking/manage_voucher/'.$row->booking_id,
                    ],
                    [
                        'name'  => __('Edit Voucher'),
                        'class' => 'active'
                    ],
                ]
            ];
        return view('Report::admin.booking.edit-voucher', $data);
    }
    public function delete_voucher(Request $request, $id)
    {
        $this->manageVoucherClass::find($id)->delete();
        return back()->with('success', __('Voucher deleted'));
    }
    public function storeVoucher(Request $request, $id)
    {   
        $data = $request->all();
        if ($id > 0) {
            $row = $this->manageVoucherClass::find($id);
            if (empty($row)) {
                return redirect(route('tour.admin.index'));
            }

        } else {
            $row = new $this->manageVoucherClass();
        }
        
        $row->fill($request->input());
        if (!empty($data['restaurant']) && $data['voucher_type'] == 2) {
           $row->term_id = $data['restaurant'];
        }else if (!empty($data['hotels']) && $data['voucher_type'] == 3) {
             $row->term_id = $data['hotels'];
        }else if (!empty($data['transport']) && $data['voucher_type'] == 4) {
             $row->term_id = $data['transport'];
        }else{
             $row->term_id = $data['sightseeing'];
        }
        $row->save();
        if ($row) {
            if ($id > 0) {
                event(new UpdatedServiceEvent($row));

                return back()->with('success', __('Tour Voucher updated'));
            } else {
                event(new CreatedServicesEvent($row));

                return redirect(route('report.booking.manage_voucher', $row->booking_id))->with('success', __('Tour Voucher created'));
            }
        }
    }
    public function documents(Request $request, $id)
    {
            $booking = Booking::find($id);
            $data = [
                'booking'           => $booking,
                'page_title'            => __("Booking Document"),
                'breadcrumbs'       => [
                    [
                        'name' => __('Report'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name' => __('Booking'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name'  => __('Manage Voucher'),
                        'class' => 'active'
                    ],
                ]
            ];
        return view('Report::admin.booking.document', $data);
    }
    public function storeDocuments(Request $request, $id)
    {   
        $data = $request->all();
        $booking = Booking::find($id);
        $oldFiles = array();
        $newFiles = array();
        if (!empty($data['old_file'])) {
            $oldFiles = $data['old_file'];
            foreach (json_decode($booking->documents) as $key => $old) {
                if (!in_array($old, $oldFiles)) {
                    $filename = public_path().'/uploads/booking_docs/'.$old;
                     if(file_exists($filename)){
                       File::delete($filename);
                     }
                }
            }
        }
        if($request->hasFile('file')) {
            $files = $request->file('file');
            foreach ($files as $file) {
                $destinationPath = 'public/uploads/booking_docs/';
                $fullName = str_replace(" ","",$file->getClientOriginalName());
                $onlyName = explode('.',$fullName);
                if(is_array($onlyName)){
                  $fileName = $onlyName[0].time().".".$onlyName[1];
                }
                else{
                  $fileName = $onlyName.time();
                }
                $file->move(public_path().'/uploads/booking_docs/', $fileName);  
                $newFiles[] = $fileName;
            }
        }
        $docs = array_merge($newFiles,$oldFiles);
        if (count($docs) == 0) {
            $docs = null;
        }else{
          $docs = json_encode($docs);
        }
        Booking::where('id', $id)->update(['documents' => $docs]);
        
         
        return back()->with('success', __('Booking documents updated'));
    }
}
