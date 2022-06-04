<?php
namespace Plugins\PaymentRazorPay\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Plugins\PaymentRazorPay\Gateway\RazorPayCheckoutGateway;

class RazorPayCheckoutController extends Controller
{
    public function handleCheckout(Request $request,$c,$r)
    {
        $data = $request->query->all();
        if( $c == '' || $r == '')
        {
            return redirect("/");
        }
        $booking = Booking::where('code', $c)->first();
        if(!$booking)
        {
            return redirect("/");
        }

        $razorPayGateway = new RazorPayCheckoutGateway();
        $sandBoxEnable = $razorPayGateway->getOption('razorpay_enable_sandbox');
        if ($sandBoxEnable) {
            $keyId = $razorPayGateway->getOption('razorpay_test_key_id');
            $keySecret = $razorPayGateway->getOption('razorpay_test_key_secret');
        } else {
            $keyId = $razorPayGateway->getOption('razorpay_key_id');
            $keySecret = $razorPayGateway->getOption('razorpay_key_secret');
        }
        return view("PaymentRazorPay::frontend.razorpaycheckout" , ['booking'=>$booking,
            'form_url'=>$this->getReturnUrlWallet($booking->code),'key'=>$keyId,'secret' =>
                $keySecret,'cancelurl'=>$this->getCancelUrl($booking->code)]);

    }
    public function handleWallet(Request $request,$c,$r)
    {
        $data = $request->query->all();
        if( $c == '' || $r == '')
        {
            return redirect("/");
        }
        $payment = Payment::where('id', $c)->first();

        if(!$payment)
        {
            return redirect("/");
        }

        $razorPayGateway = new RazorPayCheckoutGateway();
        $sandBoxEnable = $razorPayGateway->getOption('razorpay_enable_sandbox');
        if ($sandBoxEnable) {
            $keyId = $razorPayGateway->getOption('razorpay_test_key_id');
            $keySecret = $razorPayGateway->getOption('razorpay_test_key_secret');
        } else {
            $keyId = $razorPayGateway->getOption('razorpay_key_id');
            $keySecret = $razorPayGateway->getOption('razorpay_key_secret');
        }
        $user = auth()->user();
        return view("PaymentRazorPay::frontend.razorpaywallet" , ['user'=>$user,'payment'=>$payment,
            'form_url'=>$this->getReturnUrlWallet($payment->code),'key'=>$keyId,'secret' =>
                $keySecret,'cancelurl'=>$this->getCancelUrl($payment->code)]);

    }

    public function handleProcess(Request $request, $gateway,$bookingCode)
    {
        $razorPayGateway = new RazorPayCheckoutGateway();
        return $razorPayGateway->confirmRazorPayment($request,$gateway,$bookingCode);
    }

    public function handleProcessWallet(Request $request, $gateway,$bookingCode)
    {
        $razorPayGateway = new RazorPayCheckoutGateway();
        return $razorPayGateway->confirmNormalWalletPayment($request,$gateway,$bookingCode);
    }

    public function getReturnUrl($bookingCode)
    {

        return url(app_get_locale(false,false,"/")).'/gateway_callback/processRazorPayGT/razorpay_gateway/'
            .$bookingCode;
    }

    public function getReturnUrlWallet($bookingCode)
    {

        return url(app_get_locale(false,false,"/")).'/gateway_callback/processRazorPayGTWallet/razorpay_gateway/'
            .$bookingCode;
    }

    public function getCancelUrl($bookingCode)
    {

        return url(app_get_locale(false,false,"/").config('booking.booking_route_prefix') . '/cancel/razorpay_gateway' ).'?c='.$bookingCode;
    }
}
