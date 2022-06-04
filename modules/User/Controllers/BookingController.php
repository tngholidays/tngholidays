<?php
namespace Modules\User\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Matrix\Exception;
use Modules\FrontendController;
use Modules\User\Events\NewVendorRegistered;
use Modules\User\Events\SendMailUserRegistered;
use Modules\User\Models\Newsletter;
use Modules\User\Models\Subscriber;
use Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Modules\Vendor\Models\VendorRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Validator;
use Modules\Booking\Models\Booking;
use App\Helpers\ReCaptchaEngine;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Modules\Booking\Models\Enquiry;
use Modules\Tour\Models\ManageItinerary;
use Modules\Tour\Models\ManageVoucher;
use Modules\Booking\Models\BookingProposal;
use PDF;

class BookingController extends FrontendController
{

    public function __construct()
    {
        parent::__construct();
    }


    public function bookingInvoice($code)
    {
        $booking = Booking::where('code', $code)->first();
        $user_id = Auth::id();
        if (empty($booking)) {
            return redirect('user/booking-history');
        }
        if ($booking->customer_id != $user_id and $booking->vendor_id != $user_id) {
            return redirect('user/booking-history');
        }
        $data = [
            'booking'    => $booking,
            'service'    => $booking->service,
            'page_title' => __("Invoice")
        ];
        return view('User::frontend.bookingInvoice', $data);
    }
    public function bookingItinerary($code)
    {
        $booking = Booking::where('code', $code)->first();
        $proposal = BookingProposal::where("id", $booking->proposal_id)->first();
        $tour = null;
        if(!empty($proposal)){
            $customTour = $proposal->tour_details;
            $tour = margeCustomTour($booking->object_id, $customTour);
        }
        $ManageItinerary = ManageItinerary::where('booking_id', $booking->id)->first();
        $user_id = Auth::id();
        if (empty($booking)) {
            return redirect('user/booking-history');
        }
        //if ($booking->customer_id != $user_id and $booking->vendor_id != $user_id) {
          //  return redirect('user/booking-history');
        //}
        $data = [
            'booking'    => $booking,
            'ManageItinerary' => $ManageItinerary,
            'service'    => $booking->service,
            'tour'    => $tour,
            'page_title' => __("Invoice")
        ];
        return view('User::frontend.bookingItinerary', $data);
    }
    public function addGuestDetails($code)
    {
        $booking = Booking::where('code', $code)->first();
        $row = ManageItinerary::where('booking_id', $booking->id)->first();
        if (empty($row)) {
            $row = new ManageItinerary();
            $row->fill([
                'status' => 'draft'
            ]);
        }
        $user_id = Auth::id();
        if (empty($booking)) {
            return redirect('user/booking-history');
        }
        if ($booking->customer_id != $user_id and $booking->vendor_id != $user_id) {
            return redirect('user/booking-history');
        }
        $data = [
            'booking'    => $booking,
            'row' => $row,
            'service'    => $booking->service,
            'page_title' => __("Invoice")
        ];
        return view('User::frontend.addGuestDetails', $data);
    }
    public function storeGuestDetails(Request $request, $id)
        {
            if ($id > 0) {
                $row = ManageItinerary::find($id);

                if (empty($row)) {
                     return back();
                }

            } else {
                $row = new ManageItinerary();
                $row->status = "publish";
            }
            // dd($row);
            $row->fill($request->input());
            $row->save();
            if ($row) {
               return back();
            }
        }
    public function bookingVoucher($code)
    {
        $booking = Booking::where('code', $code)->first();
        $row = ManageVoucher::with('term')->where('status', '!=', 'draft')->where('voucher_type', '!=', '3')->where('booking_id', $booking->id)->get();
        $ManageItinerary = ManageItinerary::where('booking_id', $booking->id)->first();
        $user_id = Auth::id();
        if (empty($booking)) {
            return redirect('user/booking-history');
        }
        if ($booking->customer_id != $user_id and $booking->vendor_id != $user_id) {
            return redirect('user/booking-history');
        }
        $data = [
            'booking'    => $booking,
            'rows'    => $row,
            'ManageItinerary' => $ManageItinerary,
            'service'    => $booking->service,
            'page_title' => __("Invoice")
        ];
        $pdf = PDF::loadView('User::frontend.bookingVoucher',$data);
        return $pdf->stream('bookingVoucher.pdf');

        // return view('User::frontend.bookingVoucher', $data);
    }
    public function bookingDocument($code)
    {
        $booking = Booking::where('code', $code)->first();
        $user_id = Auth::id();
        if (empty($booking)) {
            return redirect('user/booking-history');
        }
        $data = [
            'booking'    => $booking,
            'page_title' => __("Invoice")
        ];
        return view('User::frontend.bookingDocument', $data);
    }
    public function ticket($code = '')
    {
        $booking = Booking::where('code', $code)->first();
        $user_id = Auth::id();
        if (empty($booking)) {
            return redirect('user/booking-history');
        }
        if ($booking->customer_id != $user_id and $booking->vendor_id != $user_id) {
            return redirect('user/booking-history');
        }
        $data = [
            'booking'    => $booking,
            'service'    => $booking->service,
            'page_title' => __("Ticket")
        ];
        return view('User::frontend.booking.ticket', $data);
    }
    public function ticketDownload($code = '')
    {
        $booking = Booking::where('code', $code)->first();
        $service = $booking->service;
        $page_title = __("Ticket");
        // 4qrcode = QrCode::size(200)->generate($booking->id.'.'.\Illuminate\Support\Facades\Hash::make($booking->id))
        $qrcode = QrCode::format('svg')->size(200)->errorCorrection('H')->generate($booking->id.'.'.\Illuminate\Support\Facades\Hash::make($booking->id));
        $pdf = PDF::loadView('User::frontend.booking.ticketPDF',compact('page_title','service','booking','qrcode'));
        return $pdf->download('ticket.pdf');
    }

}
