<?php
namespace Plugins\PaymentRazorPay\Gateway;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use Modules\Booking\Models\Payment;
use Razorpay\Api\Api;
use Validator;
use Illuminate\Support\Facades\Log;
use Modules\Booking\Models\Booking;
use Modules\User\Events\RequestCreditPurchase;

class RazorPayCheckoutGateway extends \Modules\Booking\Gateways\BaseGateway
{
    protected $id   = 'razorpay_gateway';
    public    $name = 'Razorpay Checkout';
    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Razorpay Checkout?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("Razorpay Checkout"),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Custom Logo'),
            ],[
                'type'    => 'select',
                'id'      => 'convert_to',
                'label'   => __('Convert To'),
                'desc'    => __('In case of main currency does not support by RazorPay. You must select currency and input exchange_rate to currency that RazorPay support'),
                'options' => $this->supportedCurrency()
            ],
            [
                'type'       => 'input',
                'input_type' => 'number',
                'id'         => 'exchange_rate',
                'label'      => __('Exchange Rate'),
                'desc'       => __('Example: Main currency is VND (which does not support by RazorPay), you may want to convert it to USD when customer checkout, so the exchange rate must be 23400 (1 USD ~ 23400 VND)'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Custom HTML Description'),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'input',
                'id'    => 'razorpay_key_id',
                'label' => __('Key ID'),
            ],
            [
                'type'  => 'input',
                'id'    => 'razorpay_key_secret',
                'label' => __('Key Secret'),
            ],
            [
                'type'  => 'checkbox',
                'id'    => 'razorpay_enable_sandbox',
                'label' => __('Enable Sandbox Mode'),
            ],
            [
                'type'       => 'input',
                'id'        => 'razorpay_test_key_id',
                'label'     => __('Test Key ID'),
            ],
            [
                'type'       => 'input',
                'id'        => 'razorpay_test_key_secret',
                'label'     => __('Test Key Secret'),
            ]
        ];
    }

    public function process(Request $request, $booking, $service)
    {
        if (in_array($booking->status, [
            $booking::PAID,
            $booking::COMPLETED,
            $booking::PARTIAL_PAYMENT,
            $booking::CANCELLED
        ])) {

            throw new Exception(__("Booking status does need to be paid"));
        }
        if (!$booking->total) {
            throw new Exception(__("Booking total is zero. Can not process payment gateway!"));
        }

        $sandBoxEnable = $this->getOption('razorpay_enable_sandbox');
        if ($sandBoxEnable) {
            $keyId = $this->getOption('razorpay_test_key_id');
            $keySecret = $this->getOption('razorpay_test_key_secret');
        } else {
            $keyId = $this->getOption('razorpay_key_id');
            $keySecret = $this->getOption('razorpay_key_secret');
        }

        if ($keyId == '' || $keySecret == '')
        {
            return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));
        }

        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->payment_gateway = $this->id;
        $payment->status = 'draft';
        $data = $this->handlePurchaseData([
            'amount' => (float)$booking->total,
            'order_id' => $booking->code,
        ], $booking, $service,$payment);
        $payment->save();
        $booking->status = ($booking->status == 'partial_payment' ? $booking::PARTIAL_PAYMENT : $booking::UNPAID);
        $booking->payment_id = $payment->id;
        $booking->save();

        $orderData = [
            'receipt' => $payment->id."",
            'amount' => (float)$data['amount'] * 100, // 2000 rupees in paise
            'currency' => strtoupper($data['currency']),
            'payment_capture' => 1 // auto capture
        ];

        $razorpayOrder  = $this->generateRazorPayOrder($orderData,$keyId,$keySecret,$sandBoxEnable);

        if($razorpayOrder)
        {
            $razorpayOrder = json_decode($razorpayOrder,true);
            if(isset($razorpayOrder['error']) && !empty($razorpayOrder['error']))
            {
                $payment = $booking->payment;
                if ($payment) {
                    $payment->status = 'fail';
                    $payment->logs = \GuzzleHttp\json_encode($razorpayOrder);
                    $payment->save();
                }
                return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));

            }else if (isset($razorpayOrder['id']) && !empty($razorpayOrder['id'])) {
                $queryData = [];
                $queryData['c'] = $data['cart_order_id'];
                $queryData['r']= $razorpayOrder['id'];
                $booking->addMeta('razorpay_order_id',$razorpayOrder['id']);
                $booking->addMeta('razorpay_order_log',json_encode($razorpayOrder));
                $paynow_args = http_build_query($queryData, '', '&');

                return response()->json([
                    'url' => route('checkoutRazorPayGateway',[$queryData['c'],$queryData['r']])
                ])->send();
            } else {
                $payment = $booking->payment;
                if ($payment) {
                    $payment->status = 'fail';
                    $payment->logs = \GuzzleHttp\json_encode($razorpayOrder);
                    $payment->save();
                }
                return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));
            }

        }else{
            return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));
        }

    }
    public function processNormal($payment)
    {

        $sandBoxEnable = $this->getOption('razorpay_enable_sandbox');
        if ($sandBoxEnable) {
            $keyId = $this->getOption('razorpay_test_key_id');
            $keySecret = $this->getOption('razorpay_test_key_secret');
        } else {
            $keyId = $this->getOption('razorpay_key_id');
            $keySecret = $this->getOption('razorpay_key_secret');
        }
        $payment->payment_gateway = $this->id;
        $data = $this->handlePurchaseDataNormal([
            'amount'        => (float)$payment->amount,
            'transactionId' => $payment->code . '.' . time()
        ],  $payment);


        $orderData = [
            'receipt' => $payment->id."",
            'amount' => (float)$data['amount'] * 100, // 2000 rupees in paise
            'currency' => strtoupper($data['currency']),
            'payment_capture' => 1 // auto capture
        ];

        $razorpayOrder  = $this->generateRazorPayOrder($orderData,$keyId,$keySecret,$sandBoxEnable);
        

        if($razorpayOrder)
        {   
            $razorpayOrder = json_decode($razorpayOrder,true);
            if(isset($razorpayOrder['error']) && !empty($razorpayOrder['error']))
            {
                if ($payment) {
                    $payment->status = 'fail';
                    $payment->logs = \GuzzleHttp\json_encode($razorpayOrder);
                    $payment->save();
                }
                return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));

            }else if (isset($razorpayOrder['id']) && !empty($razorpayOrder['id'])) {
                $queryData = [];
                $queryData['c'] = $data['cart_order_id'];
                $queryData['r']= $razorpayOrder['id'];
                $payment->gateway_order = json_encode($razorpayOrder);
                $payment->save();
                $paynow_args = http_build_query($queryData, '', '&');
                return \Redirect::route('handleWalletRazorPayGateway',[$queryData['c'],$queryData['r']])->send();
            } else {
                if ($payment) {
                    $payment->status = 'fail';
                    $payment->logs = \GuzzleHttp\json_encode($razorpayOrder);
                    $payment->save();
                }
                return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));
            }

        }else{
            return redirect($booking->getDetailUrl())->with("error", __("Payment Failed"));
        }

    }

    public function handlePurchaseData($data, $booking, $request, &$payment = null)
    {
        $razorpaycheckout_args = array();
        $main_currency = setting_item('currency_main');
        $supported = $this->supportedCurrency();
        $convert_to = $this->getOption('convert_to');
        if($payment)
        {
            $payment->currency = $main_currency;
            $payment->amount = ((float)$booking->pay_now);
        }
        $razorpaycheckout_args['currency'] = $main_currency;
        $razorpaycheckout_args['cart_order_id'] = $booking->code;
        $razorpaycheckout_args['amount'] = ((float)$booking->pay_now);
        $razorpaycheckout_args['description'] = setting_item("site_title")." - #".$booking->id;
        $razorpaycheckout_args['return_url'] = $this->getCancelUrl() . '?c=' . $booking->code;
        $razorpaycheckout_args['x_receipt_link_url'] = $this->getReturnUrl() . '?c=' . $booking->code;
        $razorpaycheckout_args['currency_code'] = setting_item('currency_main');
        $razorpaycheckout_args['card_holder_name'] = $booking->first_name . ' ' . $booking->last_name;
        $razorpaycheckout_args['street_address'] = $booking->address;
        $razorpaycheckout_args['street_address2'] = $booking->address2;
        $razorpaycheckout_args['city'] = $booking->city;
        $razorpaycheckout_args['state'] = $booking->state;
        $razorpaycheckout_args['country'] = $booking->country;
        $razorpaycheckout_args['zip'] = $booking->zip;
        $razorpaycheckout_args['phone'] = "";
        $razorpaycheckout_args['email'] = $booking->email;
        $razorpaycheckout_args['lang'] = app()->getLocale();
        $supported = array_change_key_case($supported);
        if (!array_key_exists($main_currency, $supported)) {
            if (!$convert_to) {
                throw new Exception(__("RazorPay does not support currency: :name", ['name' => $main_currency]));
            }
            if (!$exchange_rate = $this->getOption('exchange_rate')) {
                throw new Exception(__("Exchange rate to :name must be specific. Please contact site owner", ['name' => $convert_to]));
            }
            if ($payment) {

                $payment->converted_currency = $convert_to;
                $payment->converted_amount = $booking->pay_now / $exchange_rate;
                $payment->exchange_rate = $exchange_rate;
            }
            $razorpaycheckout_args['amount'] = number_format( $booking->pay_now / $exchange_rate , 2 );
            $razorpaycheckout_args['currency'] = $convert_to;


        }


        return $razorpaycheckout_args;
    }
    public function handlePurchaseDataNormal($data, &$payment = null)
    {
        $razorpaycheckout_args = array();
        $main_currency = setting_item('currency_main');
        $supported = $this->supportedCurrency();
        $convert_to = $this->getOption('convert_to');
         $user = auth()->user();
        if($payment)
        {
            $payment->currency = $main_currency;
            $payment->amount = ((float)$payment->amount);
        }
        $razorpaycheckout_args['currency'] = $main_currency;
        $razorpaycheckout_args['cart_order_id'] = $payment->id;
        $razorpaycheckout_args['amount'] = ((float)$payment->amount);
        $razorpaycheckout_args['return_url'] = $this->getCancelUrl() . '?c=' . $payment->code;
        $razorpaycheckout_args['x_receipt_link_url'] = $this->getReturnUrl() . '?c=' . $payment->code;
        $razorpaycheckout_args['currency_code'] = setting_item('currency_main');
        $razorpaycheckout_args['card_holder_name'] = $user->first_name . ' ' . $user->last_name;
        $razorpaycheckout_args['street_address'] = $user->address;
        $razorpaycheckout_args['street_address2'] = $user->address2;
        $razorpaycheckout_args['city'] = $user->city;
        $razorpaycheckout_args['state'] = $user->state;
        $razorpaycheckout_args['country'] = $user->country;
        $razorpaycheckout_args['zip'] = $user->zip;
        $razorpaycheckout_args['phone'] = "";
        $razorpaycheckout_args['email'] = $user->email;
        $razorpaycheckout_args['lang'] = app()->getLocale();
        $supported = array_change_key_case($supported);
        if (!array_key_exists($main_currency, $supported)) {
            if (!$convert_to) {
                throw new Exception(__("RazorPay does not support currency: :name", ['name' => $main_currency]));
            }
            if (!$exchange_rate = $this->getOption('exchange_rate')) {
                throw new Exception(__("Exchange rate to :name must be specific. Please contact site owner", ['name' => $convert_to]));
            }
            if ($payment) {

                $payment->converted_currency = $convert_to;
                $payment->converted_amount = $payment->amount / $exchange_rate;
                $payment->exchange_rate = $exchange_rate;
            }
            $razorpaycheckout_args['amount'] = number_format( $payment->amount / $exchange_rate , 2 );
            $razorpaycheckout_args['currency'] = $convert_to;


        }


        return $razorpaycheckout_args;
    }

    public function getDisplayHtml()
    {
        return $this->getOption('html', '');
    }

    public function confirmRazorPayment($request,$gateway,$bookingCode)
    {

        $booking = Booking::where('code', $bookingCode)->first();
        if (!empty($booking) and in_array($booking->status, [$booking::UNPAID])) {

            $sandBoxEnable = $this->getOption('razorpay_enable_sandbox');
            if ($sandBoxEnable) {
                $keyId = $this->getOption('razorpay_test_key_id');
                $keySecret = $this->getOption('razorpay_test_key_secret');
            } else {
                $keyId = $this->getOption('razorpay_key_id');
                $keySecret = $this->getOption('razorpay_key_secret');
            }

            $orderId = $request->razorpay_order_id;
            $paymentId = $request->razorpay_payment_id;
            $payload = $orderId . '|' . $paymentId;
            $actualSignature = hash_hmac('sha256', $payload, $keySecret);
            if ($actualSignature != $request->razorpay_signature) {
                $payment = $booking->payment;
                if ($payment) {
                    $payment->status = 'fail';
                    $payment->logs = \GuzzleHttp\json_encode($request->input());
                    $payment->save();
                }
                try {
                    $booking->markAsPaymentFailed();
                } catch (\Swift_TransportException $e) {
                    Log::warning($e->getMessage());
                }
                Session::flash('error', __("Payment Failed"));
                return $booking->getDetailUrl();

            } else {
                $payment = $booking->payment;
                if ($payment) {
                    $payment->status = 'completed';
                    $payment->logs = \GuzzleHttp\json_encode($request->input());
                    $payment->save();
                }
                try {
                    $booking->paid += (float)$booking->pay_now;
                    $booking->markAsPaid();
                } catch (\Swift_TransportException $e) {
                    Log::warning($e->getMessage());
                }
                Session::flash('success', __("You payment has been processed successfully"));
                return $booking->getDetailUrl();
            }
        }
        if (!empty($booking)) {
            return $booking->getDetailUrl(false);
        } else {
            return url('/');
        }
    }

    public function confirmNormalWalletPayment($request,$gateway,$bookingCode)
    {
        /**
         * @var Payment $payment
         */
        $request = \request();
        $payment = Payment::where('code', $bookingCode)->first();


        if (!empty($payment)) {

            $sandBoxEnable = $this->getOption('razorpay_enable_sandbox');
            if ($sandBoxEnable) {
                $keyId = $this->getOption('razorpay_test_key_id');
                $keySecret = $this->getOption('razorpay_test_key_secret');
            } else {
                $keyId = $this->getOption('razorpay_key_id');
                $keySecret = $this->getOption('razorpay_key_secret');
            }

            $orderId = $request->razorpay_order_id;
            $paymentId = $request->razorpay_payment_id;
            $payload = $orderId . '|' . $paymentId;
            $actualSignature = hash_hmac('sha256', $payload, $keySecret);
            if ($actualSignature != $request->razorpay_signature) {
                if ($payment) {
                    $payment->status = 'fail';
                    $payment->logs = \GuzzleHttp\json_encode($request->input());
                    $payment->save();
                }
                try {
                    $booking->markAsPaymentFailed();
                } catch (\Swift_TransportException $e) {
                    Log::warning($e->getMessage());
                }
                Session::flash('error', __("Payment Failed"));
                $redirect_url = route('user.wallet');
                return $redirect_url;

            } else {
                if ($payment) {
                    $payment->status = 'completed';
                    $payment->logs = \GuzzleHttp\json_encode($request->input());
                    $payment->save();

                    // $payment->markAsCompleted($request->input());
                    $deposit_credit = $payment->getMeta('credit');

                    $user = auth()->user();
                    $transaction = $user->deposit($deposit_credit,[],false);
                    $transaction->payment_id = $payment->id;
                    $transaction->save();
                    if (!empty($user->wallet)) {
                        $user->wallet->balance += $deposit_credit;
                        $user->wallet->save();
                    }

                    $payment->wallet_transaction_id = $transaction->id;
                    $payment->save();
                    event(new RequestCreditPurchase($user, $payment));

                    $redirect_url = route('user.wallet');
                    Session::flash('success', __("Transaction successfully completed"));
                    return $redirect_url;
                }
                try {
                    $payment->markAsPaid();
                } catch (\Swift_TransportException $e) {
                    Log::warning($e->getMessage());
                }
                // Session::flash('success', __("You payment has been processed successfully"));
                // return url('user/wallet');
            }
        }
        if (!empty($booking)) {
            return url('user/wallet');
        } else {
            return url('user/wallet');
        }



    }

    public function cancelPayment(Request $request)
    {

        $c = $request->query('c');
        $booking = Booking::where('code', $c)->first();

        if (!empty($booking) and in_array($booking->status, [$booking::UNPAID])) {
            $payment = $booking->payment;

            if ($payment) {
                $payment->status = 'cancel';
                $payment->logs = \GuzzleHttp\json_encode([
                    'customer_cancel' => 1
                ]);
                $payment->save();
            }
            return redirect($booking->getDetailUrl())->with("error", __("You cancelled the payment"));
        }

        if (!empty($booking)) {
            return redirect($booking->getDetailUrl());
        } else {
            return redirect(url('/'));
        }
    }

    public function supportedCurrency()
    {
        return [
            'INR' => 'Indian rupee',
        ];
    }

    public function generateRazorPayOrder($orderData,$key_id,$keySecret,$enableSandbox=false)
    {
        $ch = curl_init();

        $url = 'https://api.razorpay.com/v1/orders';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $keySecret);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
}
