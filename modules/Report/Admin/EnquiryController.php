<?php
namespace Modules\Report\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Booking\Models\Enquiry;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\BookingProposal;
use Modules\Tour\Models\Tour;
use Modules\Tour\Models\ManageItinerary;
    use Modules\Core\Models\Attributes;
    use Modules\Tour\Models\TourCategory;
        use Modules\Location\Models\Location;
        use Modules\Location\Models\LocationCategory;
            use Modules\Coupon\Models\Coupon;
 use Modules\Core\Events\CreatedServicesEvent;
    use Modules\Core\Events\UpdatedServiceEvent;
    use Illuminate\Auth\Events\Registered;
    use Modules\User\Events\NewVendorRegistered;
    use Modules\User\Events\SendMailUserRegistered;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Database\Eloquent\Collection;
      use Propaganistas\LaravelPhone\PhoneNumber;
  use Modules\Sms\Core\Facade\Sms;
    use PDF;
    use Mail;
    use Validator;


class EnquiryController extends AdminController
{
    protected $enquiryClass;
    protected $tourClass;
    protected $manageItineraryClass;

    public function __construct()
    {
        $this->setActiveMenu('admin/module/report/booking');
        parent::__construct();
        $this->enquiryClass = Enquiry::class;
        $this->tourClass = Tour::class;
        $this->manageItineraryClass = ManageItinerary::class;

    }
        public function storeCustomTour(Request $request, $id)
        {
            $data = $request->input();
            if (isset($data['itinerary'])) {
              $data['itinerary'] = array_values($data['itinerary']);
            }
            $tour_details = $data;
            unset($tour_details['enquiry_id']);
            unset($tour_details['step']);
            unset($tour_details['name']);
            unset($tour_details['destination']);
            unset($tour_details['duration']);
            unset($tour_details['tour_id']);
            unset($tour_details['start_date']);
            $data['tour_details'] = $tour_details;
            $data['duration'] = $data['proposalDuration'];
            if ($id > 0) {
                $row = BookingProposal::find($id);
            } else {
                $row = new BookingProposal();
                $row->status = "publish";
            }

            if (isset($data['start_date'])) {
              $data['start_date'] = str_replace("/", "-", $data['start_date']);
            }
            Enquiry::where("id", $row->enquiry_id)->update(['object_id'=>$data['tour_id']]);
            unset($data['itinerary']);
            unset($data['person_types']);
            unset($data['extra_price']);
            $row->fill($data);
            $row->save();

            if ($row) {
                if ($id > 0) {
                    return redirect(route('report.booking.customTour', ['id'=>$row->enquiry_id,'tour_id'=>$row->tour_id]))->with('success', __('Custom Tour updated'));
                } else {
                  return redirect(route('report.booking.customTour', ['id'=>$row->enquiry_id,'tour_id'=>$row->tour_id]))->with('success', __('Custom Tour created'));
  
                }
            }
        }
      public function customTour(Request $request, $id, $tour_id=null)
      {


            $row = $this->tourClass::find($tour_id);
            if (empty($row)) {
                $row = new $this->tourClass;
                $row->fill([
                    'status' => 'publish'
                ]);
            }


            $translation = $row->translateOrOrigin($request->query('lang'));
            $enquiry = $this->enquiryClass::where("id", $id)->first();
            $praposal = BookingProposal::where("enquiry_id", $enquiry->id)->first();
            if(!empty($praposal) && isset($praposal->tour_details['itinerary'])){
             $customTour = @$praposal->tour_details;
            $row = margeCustomTour($tour_id, $customTour);
            $translation->itinerary = isset($customTour['itinerary']) ? $customTour['itinerary'] : null;
            }
           
            $destination_id = !empty(@$praposal->destination) ? $praposal->destination : $enquiry->destination;
            $attributesIds = [];
            $listByLocation = $this->tourClass::select('id')->where("location_id", $destination_id)->where("status", "publish")->get();
            if (!empty($listByLocation)) {
                foreach ($listByLocation as $row1) {
                    $idss = $row1->tour_term->pluck('term_id')->toArray();
                   $attributesIds=array_merge($attributesIds,$idss);
                }
            }

            $terms = $row->tour_term->pluck('term_id')->toArray();
            if(!empty($customTour) && isset($customTour['terms'])) {
              $terms = $customTour['terms'];
            }
            if (empty($praposal)) {
                $praposal = new BookingProposal();
                $praposal->fill([
                    'status' => 'publish'
                ]);
            }
            $data = [
                'row'               => $row,
                'translation'       => $translation,
                "selected_terms"    => $terms,
                'attributes'        => Attributes::where('service', 'tour')->get(),
                'tour_category'     => TourCategory::where('status', 'publish')->get()->toTree(),
                'tour_location'     => Location::where('status', 'publish')->get()->toTree(),
                'location_category' => LocationCategory::where("status", "publish")->get(),
                'coupons'       => Coupon::where(["status"=>"publish","delete_status"=>1])->get(),
                'enable_multi_lang' => true,
                'translation'       => $translation,
                'enquiry'           => $enquiry,
                'praposal'          => $praposal,
                'attributesIds'     => $attributesIds,
                'breadcrumbs'       => [
                    [
                        'name' => __('Tours'),
                        'url'  => 'admin/module/tour'
                    ],
                    [
                        'name'  => __('Edit Tour'),
                        'class' => 'active'
                    ],
                ]
            ];
            return view('Report::admin.booking.custom_tour', $data);
    }
    public function index(Request $request)
    {
        $this->checkPermission('enquiry_view');
        $query = $this->enquiryClass::where('status', '!=', 'draft');
        if (!empty($request->s)) {
            $query->where('email', 'LIKE', '%' . $request->s . '%');
            $query->orderBy('email', 'asc');
            $title_page = __('Search results: ":s"', ["s" => $request->s]);
        }
        $query->whereIn('object_model', array_keys(get_bookable_services()));
        $query->orderBy('id','desc');
        $data = [
            'rows'                  => $query->paginate(20),
            'breadcrumbs' => [
                [
                    'name' => __('Enquiry'),
                    'url'  => 'admin/module/report/enquiry'
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            'enquiry_update'        => $this->hasPermission('enquiry_update'),
            'enquiry_manage_others' => $this->hasPermission('enquiry_manage_others'),
            'statues'        => $this->enquiryClass::$enquiryStatus,
            'page_title'=> $title_page ?? __("Enquiry Management")
        ];

        return view('Report::admin.enquiry.index', $data);
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
                $query = $this->enquiryClass::where("id", $id);
                if (!$this->hasPermission('enquiry_manage_others')) {
                    $query->where("vendor_id", Auth::id());
                    $this->checkPermission('enquiry_update');
                }
                $query->first();
                if(!empty($query)){
                    $query->delete();
                }
            }
        } else {
            foreach ($ids as $id) {
                $query = $this->enquiryClass::where("id", $id);
                if (!$this->hasPermission('enquiry_manage_others')) {
                    $query->where("vendor_id", Auth::id());
                    $this->checkPermission('enquiry_update');
                }
                $item = $query->first();
                if(!empty($item)){
                    $item->status = $action;
                    $item->save();
                }
            }
        }
        return redirect()->back()->with('success', __('Update success'));
    }
    public function copyEnquiry(Request $request, $id)
   {
           $enquiry = $this->enquiryClass::find($id);
           $enquiry = $enquiry->replicate();
           $enquiry->object_id = null;
           $enquiry->save();
           return back()->with('success', __('Duplicate created successfully'));
    }
     public function booking_proposal(Request $request, $id, $tour_id=null)
    {
            $enquiry = $this->enquiryClass::where("id", $id)->first();
            $row = BookingProposal::where("enquiry_id", $enquiry->id)->first();
            $destination_id = !empty($row->destination) ? $row->destination : $enquiry->destination;
            $attributesIds = [];
            $listByLocation = $this->tourClass::select('id')->where("location_id", $destination_id)->where("status", "publish")->get();
            if (!empty($listByLocation)) {
                foreach ($listByLocation as $row1) {
                    $idss = $row1->tour_term->pluck('term_id')->toArray();
                   $attributesIds=array_merge($attributesIds,$idss);
                }
            }
            $old_row = $row;
            $customTour = $row->tour_details;
            $tour = margeCustomTour($tour_id, $customTour);
            $data = [
                'row'               => $row,
                'old_row'               => $old_row,
                'custom_tour'               => $customTour,
                'enquiry'           => $enquiry,
                'tour'              => $tour,
                'step'              => '',
                'attributesIds'     => array_unique($attributesIds),
                'page_title'            => __("Booking Proposal "),
                'breadcrumbs'       => [
                    [
                        'name' => __('Report'),
                        'url'  => 'admin/module/report/booking'
                    ],
                    [
                        'name' => __('Enquiry'),
                        'url'  => 'admin/module/report/enquiry'
                    ],
                    [
                        'name'  => __('Booking Praposal'),
                        'class' => 'active'
                    ],
                ]
            ];
         return view('Report::admin.booking.booking_proposal', $data);
    }

    public function storeProposal(Request $request, $id)
        {
            $data = $request->input();

            if ($id > 0) {
                $row = BookingProposal::find($id);
                if ($data['old_tour_id'] != $data['tour_id']) {
                  if (isset($data['start_date'])) {
                    $data['start_date'] = str_replace("/", "-", $data['start_date']);
                  }
                  $row->destination = $data['destination'];
                  $row->duration = $data['duration'];
                  $row->start_date = $data['start_date'];
                  $row->save();
                   $this->enquiryClass::where("id", $row->enquiry_id)->update(['object_id'=>$data['tour_id']]);
                  return redirect(route('report.booking.booking_proposal', ['id'=>$row->enquiry_id,'tour_id'=>$data['tour_id']]));
                }
                if (empty($row)) {
                    return redirect(route('tour.admin.index'));
                }
                if ($row->create_user != Auth::id() and !$this->hasPermission('tour_manage_others')) {
                    return redirect(route('tour.admin.index'));
                }

            } else {
                $row = new BookingProposal();
                $row->status = "publish";
            }


            if (isset($data['start_date'])) {
              $data['start_date'] = str_replace("/", "-", $data['start_date']);
            }
            $data['tour_details'] = $row->tour_details;
            $data['default_hotels'] = $row->default_hotels;
            $row->fill($data);
            $row->save();

            if ($row) {
                if ($id > 0) {
                    // event(new UpdatedServiceEvent($row));
                    return redirect(route('report.booking.booking_proposal', ['id'=>$row->enquiry_id,'tour_id'=>$row->tour_id]))->with('success', __('Booking Proposal updated'));
                } else {
                    // event(new CreatedServicesEvent($row));
                    return redirect(route('report.booking.booking_proposal', ['id'=>$row->enquiry_id,'tour_id'=>$row->tour_id]))->with('success', __('Booking Proposal created'));
                }
            }
        }
      public function viewProposal(Request $request, $id, $action=null)
       {


           $enquiry = $this->enquiryClass::find($id);;

           $row = BookingProposal::where("enquiry_id", $id)->first();
           $customTour = $row->tour_details;
           $tour = margeCustomTour($row->tour_id, $customTour);
           $data = [
               'row'               => $row,
               'enquiry'           => $enquiry,
               'terms'             => $customTour['terms'],
               'tour'              => $tour,
               'page_title'            => __("Booking Proposal "),
               'breadcrumbs'       => [
                   [
                       'name' => __('Report'),
                       'url'  => 'admin/module/report/booking'
                   ],
                   [
                       'name' => __('Enquiry'),
                       'url'  => 'admin/module/report/enquiry'
                   ],
                   [
                       'name'  => __('Booking Praposal'),
                       'class' => 'active'
                   ],
               ]
           ];
           // return view('Report::admin.booking.proposalPDF', $data);
           $pdf = PDF::loadView('Report::admin.booking.proposalPDF',$data);
           $output = $pdf->output();
           $name = @$enquiry->name.'proposal-'.$enquiry->id; 
           $file_name = $name.'.pdf';
           $filepath = public_path().'/voucher/'.$file_name;
           $data['filepath'] = asset('voucher/'.$file_name);
           file_put_contents($filepath, $output);
           if ($request->isMethod('post')) {
             if ($action != null && !empty($enquiry->email)) {
               $toEmail = $enquiry->email;
               try{
                  Mail::send('Booking::emails.mail-proposal', $data, function( $message ) use ($data, $toEmail, $output, $filepath)
                  {
                     $message->to($toEmail)->subject('Booking Proposal');
                     $message->attachData($output, $filepath);
                   });
               }
               catch(\Exception $e){
               }
             }
             if ($action != null && !empty($enquiry->phone)) {
                 $to = (string)PhoneNumber::make($enquiry->phone)->ofCountry('IN');
                 $title = 'Proposal for '.$tour->title;
              //    $version = "?var=".rand(); 
				          // $pathPDF = asset('voucher/proposalPDF.pdf').$version;
                 $destinationPath = 'public/voucher/';
                 $pathPDF = asset($destinationPath.$file_name);
                 Sms::to($to)->content($title)->file($pathPDF)->send();
                 if(file_exists($filepath)){
                  File::delete($filepath);
                 }
             }
             
             return back()->with('success', __('Proposal Sent!'));

           }
           return view('Report::admin.booking.view-proposal', $data);
       }
       public function viewProposalFromLead(Request $request, $id, $action=null)
       {


           $enquiry = $this->enquiryClass::find($id);;

           $row = BookingProposal::where("enquiry_id", $id)->first();
           $customTour = $row->tour_details;
           $tour = margeCustomTour($row->tour_id, $customTour);
           $data = [
               'row'               => $row,
               'enquiry'           => $enquiry,
               'terms'             => $customTour['terms'],
               'tour'              => $tour
           ];
           // return view('Report::admin.booking.proposalPDF', $data);
           $pdf = PDF::loadView('Report::admin.booking.proposalPDF',$data);
           return $pdf->stream();
       }
       public function bookingForm(Request $request, $id)
       {
         $enquiry = $this->enquiryClass::find($id);
         $row = BookingProposal::where("enquiry_id", $id)->first();
         $user =  \App\User::where('phone',$enquiry->phone)->orWhere('email',$enquiry->email)->first();
         if (empty($user)) {
           $name = explode(' ', $enquiry->name);
           $user = New \App\User();
            $user->first_name = (isset($name[0]) ? $name[0] : null);
            $user->last_name = (isset($name[1]) ? $name[1] : null);
            $user->email = $enquiry->email;
            $user->phone = $enquiry->phone;
         }
         $data = [
             'row'               => $row,
             'enquiry'           => $enquiry,
             'user'           => $user,
             'page_title'            => __("Booking Proposal "),
             'breadcrumbs'       => [
                 [
                     'name' => __('Report'),
                     'url'  => 'admin/module/report/booking'
                 ],
                 [
                     'name' => __('Enquiry'),
                     'url'  => 'admin/module/report/enquiry'
                 ],
                 [
                     'name'  => __('Booking Praposal'),
                     'class' => 'active'
                 ],
             ]
         ];
         return view('Report::admin.booking.booking-form', $data);
       }
       public function bookingByAdmin(Request $request, $id)
       {
         $userData = $request->all();
         $enquiry = $this->enquiryClass::find($id);
         $userData['password'] = '12345678';
         $bookingProposal = BookingProposal::where("enquiry_id", $id)->first();

           $service_type = $enquiry->object_model;
           $service_id = $enquiry->object_id;
           $allServices = get_bookable_services();
           if (empty($allServices[$service_type])) {
               return redirect()->back()->with('error', __('Service type not found'));
           }
           $module = $allServices[$service_type];
           $service = $module::find($service_id);
           if (empty($service) or !is_subclass_of($service, '\\Modules\\Booking\\Models\\Bookable')) {
               return redirect()->back()->with('error', __('Service not found'));
           }
           if (!$service->isBookable()) {
               return redirect()->back()->with('error', __('Service is not bookable'));
           }
           // $userData['email'] = 'rinkumahawar99@gmail.com';
           // $userData['phone'] = '212154545';
           $user =  \App\User::select('id')->where('phone',$userData['phone'])->orWhere('email',$userData['email'])->first();
           if (!empty($user)) {
             $user_id = $user->id;
           }else{
             $user_id = $this->userRegister($userData);

           }
           $requestData = array();
           $extra_prices = [];
           if (!empty($bookingProposal->extra_price)) {
             foreach ($bookingProposal->extra_price as $key => $extra_price) {
               if (isset($extra_price['enable'])) {
                 $extra_price['enable'] = true;
                  $extra_price['per_person'] = 'on';
               }else {
                 $extra_price['enable'] = 0;
               }
               $extra_prices[] = $extra_price;
             }
           }

           $default_hotels = [];
           if (!empty($bookingProposal->default_hotels)) {
             foreach ($bookingProposal->default_hotels as $key => $hotel) {
               $default_hotels[] = $hotel;
             }
           }
           $requestData['service_id'] = $service_id;
           $requestData['service_type'] = $service_type;
           $requestData['start_date'] = date('Y-m-d', strtotime($bookingProposal->start_date));
           $requestData['person_types'] = $bookingProposal->person_types;
           $requestData['default_hotels'] = $default_hotels;
           $requestData['extra_price'] = $extra_prices;
           $requestData['guests'] = 1;
           $requestData['proposal_discount'] = $bookingProposal->discount;
           $requestData['tour_details'] = $bookingProposal->tour_details;
           $requestData['proposal_id'] = $bookingProposal->id;
           $requestData['custom_tour'] = $bookingProposal->tour_details;
           $requestData['discount_by_people'] = $bookingProposal->discount_by_people;
           
           $request->merge($requestData);
           $code = $service->addToCartByAdmin($request)->original;
           if ($code['status'] == 0) {
             return redirect('admin/module/report/enquiry')->with('error', $code['message']);
           }
           $code = $code['booking_code'];

           $bookingData = array(
             "code" => $code,
             "user_id" => $user_id,
             "first_name" => $userData['first_name'],
             "last_name" => $userData['last_name'],
             "email" => $userData['email'],
             "phone" =>  $userData['phone'],
             "address_line_1" => $userData['address_line_1'],
             "address_line_2" => $userData['address_line_2'],
             "city" => $userData['city'],
             "state" => $userData['state'],
             "zip_code" => $userData['zip_code'],
             "country" => $userData['country'],
             "customer_notes" => $userData['customer_notes'],
             "gstn" => $userData['gstn'],
             "gst_holder_name" => $userData['gst_holder_name'],
             "how_to_pay" => "deposit",
             "payment_gateway" => "offline_payment",
             "term_conditions" => "on",
             "credit" => "0"
           );
           $request->merge($bookingData);
           if ($this->doCheckout($request) == 1) {
             $bookingProposal->booking_status = 1;
             $bookingProposal->save();
             return redirect()->back()->with('success', __('Booking confirmed'));
           }else {
             return redirect()->back()->with('error', __('Something went wrong'));
           }
       }
       public function doCheckout(Request $request)
       {
         // dd($request->all());
         $data = $request->all();
           /**
            * @var $booking Booking
            * @var $user User
            */
           $booking = Booking::where('code',$request->input('code'))->first();
           // dd($booking);
           $service = $booking->service;
           $how_to_pay = $request->input('how_to_pay', '');
           $credit = $request->input('credit', 0);
           $payment_gateway = $request->input('payment_gateway');
           $credit = 0;
           $wallet_total_used = credit_to_money($credit);
           if($wallet_total_used > $booking->total){
               $credit = money_to_credit($booking->total,true);
               $wallet_total_used = $booking->total;
           }
           // Normal Checkout
           $booking->customer_id = $request->input('user_id');
           $booking->first_name = $request->input('first_name');
           $booking->last_name = $request->input('last_name');
           $booking->email = $request->input('email');
           $booking->phone = $request->input('phone');
           $booking->address = $request->input('address_line_1');
           $booking->address2 = $request->input('address_line_2');
           $booking->city = $request->input('city');
           $booking->state = $request->input('state');
           $booking->zip_code = $request->input('zip_code');
           $booking->country = $request->input('country');
           $booking->customer_notes = $request->input('customer_notes');
           $booking->gstn = $request->input('gstn');
           $booking->gst_holder_name = $request->input('gst_holder_name');
           $booking->gateway = $payment_gateway;
           $booking->wallet_credit_used = floatval($credit);
           $booking->wallet_total_used = floatval($wallet_total_used);
           $booking->pay_now = floatval($booking->deposit == null ? $booking->total : $booking->deposit);
           $booking->status = 'processing';
           $booking->save();

           $booking->addMeta('locale',app()->getLocale());
           $booking->addMeta('how_to_pay',$how_to_pay);
           return 1;
       }
       public function userRegister($user)
       {
           $userData = $user;
            $data = [
               'userData' => $userData
           ];
           $user = \App\User::create([
               'first_name' => $user['first_name'],
               'last_name'  => $user['last_name'],
               'email'      => $user['email'],
               'password'   => Hash::make($user['password']),
               'status'    => 'publish',
               'phone'    => $user['phone'],
               'address_line_1'    => $user['address_line_1'],
               'address_line_2'    => $user['address_line_2'],
               'city'    => $user['city'],
               'state'    => $user['state'],
               'zip_code'    => $user['zip_code'],
               'country'    => $user['country'],
               'gstn'    => $user['gstn'],
               'gst_holder_name'    => $user['gst_holder_name']
           ]);
            event(new Registered($user));
           try {
               Mail::send('Booking::emails.user-credential', $data, function($message) use ($userData)
                 {
                    $message->to($userData['email'])->subject('Registered');
                });
                // event(new SendMailUserRegistered($user));
           } catch (Exception $exception) {

            //   Log::warning("SendMailUserRegistered: " . $exception->getMessage());
           }
           $user->assignRole('customer');
           return $user->id;
       }

}
