<?php
namespace Modules\Contact\Controllers;

use App\Helpers\ReCaptchaEngine;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Matrix\Exception;
use Modules\Contact\Emails\NotificationToAdmin;
use Modules\Contact\Models\Contact;
use Modules\Booking\Models\Enquiry;
use Modules\Location\Models\Location;
use Modules\Core\Models\Terms;
use Modules\Forex\Models\Forex;
use Modules\Contact\Models\ForexOrders;
use Modules\Contact\Models\ForexOrderItems;
    use Propaganistas\LaravelPhone\PhoneNumber;
  use Modules\Sms\Core\Facade\Sms;
use Illuminate\Support\Facades\Validator;
use Modules\Booking\Events\EnquirySendEvent;

class ContactController extends Controller
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $data = [
            'page_title' => __("Contact Page")
        ];
        return view('Contact::index', $data);
    }
    public function makeBoldText($orimessage) {
        $styles = array ( '*' => 'strong', '_' => 'i', '~' => 'strike');
       return preg_replace_callback('/(?<!\w)([*~_])(.+?)\1(?!\w)/',
          function($m) use($styles) { 
             return '<'. $styles[$m[1]]. '>'. $m[2]. '</'. $styles[$m[1]]. '>';
          },
          $orimessage);
    }
    public function forexIndex(Request $request)
    {
        // $endpoint = "https://api.runo.in/v1/call/logs";
        // $client = new \GuzzleHttp\Client(['headers' => ['Auth-Key' => 'dHh4bTk2eGJyMjRsMW00bA==']]);
        
        // $response = $client->request('GET', $endpoint);
        // $result = $response->getBody()->getContents();
        // $result = json_decode($result, true);

        // //$statusCode = $response->getStatusCode();
        // //$content = $response->getBody();
        // dd($content);
        $locations = Location::select('id', 'name')->where("status","publish")->orderBy('id', 'desc')->get();
        $terms = Terms::select('id', 'name')->where("attr_id", 12)->orderBy('id', 'ASC')->get();
        $data = [
            'locations' => $locations,
            'terms' => $terms,
            'page_title' => __("Forex Page")
        ];

        return view('Contact::currency_exchange', $data);
    }
    public function getForexRate(Request $request)
    {
        $data = $request->all();
        
        $row = Forex::where('country_id',$data['id'])->first();
        return $row;
    }
    public function forexStore(Request $request)
    {   
        $data = $request->all();
        
        $data['forex_order'] = array_values($data['forex_order']);
        $validator = $request->validate([
            'name'    => 'required',
            'phone'    => 'required'
        ]);
        $row = new ForexOrders();
        $row->fill($data);
        $row->status = "pending";
        $row->save();
        $orderItemMSG ="";
        if(isset($data['forex_order']) && count($data['forex_order']) > 0){
            foreach($data['forex_order'] as $key => $orderItem){
                $item = new ForexOrderItems();
                $item->fill($orderItem);
                $item->order_id = $row->id;
                $item->save();
                $i = $key+1;
            $orderItemMSG .= "---------------------------------------------------- %0a"."*Order Item $i* %0a"."Order $item->order_id %0a"."Type:$item->type %0a"."Country:{$item->ForexCountry->name} %0a"."Pay Type:$item->pay_type %0a"."Forex Amt:$item->forex_amount %0a"."INR Amt:$item->inr_amount %0a"."Forex Rate:$item->forex_rate %0a";
            }
            $msg = "*Forex Order #$row->id* %0a"."Name:$row->name %0a"."Mobile:$row->phone %0a"."{$orderItemMSG}";

            $userMsg = "Thanks for inquiry about forex exchange. we will get back soon. for more contact +919829334122";
            $to = (string)PhoneNumber::make(9829334122)->ofCountry('IN');
            Sms::to($to)->content($msg)->send();

            $to2 = (string)PhoneNumber::make($row->phone)->ofCountry('IN');
            Sms::to($to2)->content($userMsg)->send();
        }
        return redirect()->back()->with('success', 'Forex Order Submitted Successfully');
    }
    public function enquiryIndex(Request $request)
    {
        $locations = Location::select('id', 'name')->where("status","publish")->orderBy('id', 'desc')->get();
        $terms = Terms::select('id', 'name')->where("attr_id", 12)->orderBy('id', 'ASC')->get();
        $data = [
            'locations' => $locations,
            'terms' => $terms,
            'page_title' => __("Enquiry Page")
        ];
        return view('Contact::enquiry', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'   => [
                'required',
                'max:255',
                'email'
            ],
            'name'    => ['required'],
            'message' => ['required']
        ]);
        /**
         * Google ReCapcha
         */
        if(ReCaptchaEngine::isEnable()){
            $codeCapcha = $request->input('g-recaptcha-response');
            if(!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)){
                $data = [
                    'status'    => 0,
                    'message'    => __('Please verify the captcha'),
                ];
                return response()->json($data, 200);
            }
        }
        $row = new Contact($request->input());
        $row->status = 'sent';
        if ($row->save()) {
            $this->sendEmail($row);
            $data = [
                'status'    => 1,
                'message'    => __('Thank you for contacting us! We will get back to you soon'),
            ];
            return response()->json($data, 200);
        }
    }


    protected function sendEmail($contact){
        if($admin_email = setting_item('admin_email')){
            try {
                Mail::to($admin_email)->send(new NotificationToAdmin($contact));
            }catch (Exception $exception){
                Log::warning("Contact Send Mail: ".$exception->getMessage());
            }
        }
    }

    public function t(){
        return new NotificationToAdmin(Contact::find(1));
    }
    public function enquiryStore(Request $request)
    {
        $validator = $request->validate([
            'name'    => 'required',
            'phone'    => 'required'
        ]);

        /**
         * Google ReCapcha
         */

        if(ReCaptchaEngine::isEnable()){
            $codeCapcha = $request->input('g-recaptcha-response');
            if(!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)){
                $data = [
                    'status'    => 0,
                    'message'    => __('Please verify the captcha'),
                ];
                return response()->json($data, 200);
            }
        }

        $row = new Enquiry($request->input());
        $row->object_id = 1;
        $row->object_model = 'tour';
        $row->status = "pending";
        $row->vendor_id = 1;
        if(!empty(addLeadRuno($row))){
            $row->is_runo_api = 1;
        }
        if ($row->save()) {
            event(new EnquirySendEvent($row));
            $persons = 0;
            foreach ($row->person_types as $key => $per) {
                $persons += isset($per['name']) ? $per['number'] : 0;
            }
            $message = 'Thanks for Enquiry about'.'%0a Destination: '.@getLocationById(@$row->destination)->name.'%0a Duration: '.@getDurationById(@$row->duration)->name.'%0a No. of Person: '.$persons.'%0a Approx Journey Date: '.@$row->approx_date.'%0aWe will get back soon with best quotation. for more call on 7823070707';
            $to = (string)PhoneNumber::make($row->phone)->ofCountry('IN');
                Sms::to($to)->content($message)->send();
            $datas = ['row'=>$row];
            if(!empty($row->email)){
                try{
                    Mail::send('Contact::emails.enquiry', $datas, function( $message ) use ($row)
                    {
                       $message->to($row->email)->subject('Thanku for enquiry');
                    });
                    }
                catch(\Exception $e){
                    dd($e);
                }
            }
            
            $data = [
                'status'    => 1,
                'message'    => __('Thank you for contacting us! We will get back to you soon'),
            ];
            return response()->json($data, 200);
        }
    }
    public function embedEnquiry(Request $request)
    {
        $locations = Location::select('id', 'name')->where("status","publish")->orderBy('id', 'desc')->get();
        $terms = Terms::select('id', 'name')->where("attr_id", 12)->orderBy('id', 'ASC')->get();
        $data = [
            'locations' => $locations,
            'terms' => $terms,
            'page_title' => __("Enquiry Page")
        ];
        return view('Contact::embed_enquiry', $data);
    }
}
