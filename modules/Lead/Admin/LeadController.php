<?php
namespace Modules\Lead\Admin;

use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Booking\Models\Enquiry;
use Modules\Lead\Models\Lead;
use Modules\Lead\Models\Conversation;
use Modules\Lead\Models\LeadComment;
use Modules\Lead\Models\LeadEmail;
use Modules\Lead\Models\LeadReminder;
use Modules\Lead\Models\LeadHistory;
use Modules\Lead\Models\Campaign;
use Modules\Page\Models\Page;
use Modules\Page\Models\PageTranslation;
use Modules\Location\Models\Location;
use Modules\Core\Models\Terms;
use Modules\Lead\Exports\LeadExport;
use App\Whatsapp;
use Modules\Template\Models\Template;
  use Propaganistas\LaravelPhone\PhoneNumber;
  use Modules\Sms\Core\Facade\Sms;
  use Illuminate\Support\Facades\DB;
  use App\Notifications\AdminChannelServices;
  use App\User;
use Mail;
use Excel;

class LeadController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu('admin/module/Lead');
        parent::__construct();
    }
    public function changeLeadStatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Enquiry::where('id', $data['id'])->update(['status'=>$data['status']]);
            return 1;
        }
    }
    public function viewleadInfo(Request $request)
    {
     
        if ($request->isMethod('post')) {
            $data = $request->all();
            if(isset($data['phone'])){
               $enq =  Enquiry::select('id')->where('phone', 'LIKE', '%'.substr($data['phone'], 3).'%')->orderBy('id','DESC')->first();
               $data['id'] = $enq->id;
            }
            
            $row = Enquiry::with('CreateUser','UpdateUser')->find($data['id']);
            $leads = Enquiry::where('phone', 'LIKE', '%' . $row->phone . '%')->orderBy('id','DESC')->get();
            $history = LeadHistory::where('phone', $row->phone)->orderBy('id','DESC')->get();
            $reminders = LeadReminder::where('phone', $row->phone)->orderBy('id','DESC')->get();
            $locations = Location::select('id', 'name')->where("status","publish")->orderBy('id', 'desc')->get();
            $terms = Terms::select('id', 'name')->where("attr_id", 12)->orderBy('id', 'ASC')->get();
            $whatsappchat=Conversation::select('id','to_id','from_id','message','created_at')->where('mobileno',$row->phone)->orderBy('wp_id', 'desc')->get();
            $data = [
                'row' => $row,
                'history' => $history,
                'reminders' => $reminders,
                'locations' => $locations,
                'terms' => $terms,
                'leads' => $leads,
                'whatsappchat' => $whatsappchat,
            ];
            return view('Lead::admin.leadDetailModal', $data);
        }
    }
    public function sync($mobileno)
    {
      if($mobileno!="")
      {
          $data= Whatsapp::sync($mobileno);
           $output=json_decode($data);
          
           foreach(@$output->data->data->data as $key=>$val)
           {
             
              if($val->type=='chat')
              {
                $existingdata=Conversation::where('to_id',$val->to)->where('from_id',$val->from)->where('wp_id',$val->t)->count();
                 if($existingdata==0)
                 {
                  $add = new Conversation();
                  $add->to_id		=$val->to;
                  $add->mobileno		=$mobileno;
                  $add->from_id 		= $val->from;
                  $add->message       	=$val->body;
                  $add->created_at       	=date("Y-m-d H:i:s",$val->t);
                  $add->updated_at       	=date("Y-m-d H:i:s",$val->t);
                  $add->wp_data=json_encode($val);
                  $add->wp_id    = $val->t;
                  $add->save();
                }
              }
  
           }
           
           $data=Conversation::select('id','to_id','from_id','message','created_at')->where('mobileno',$mobileno)->get();
           return $data;
           
      }
      
       
    }
    public function updateLead(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            if(!empty($data['id'])){
                $row = Enquiry::find($data['id']);
            }else{
                $row = new Enquiry();
                $row->status = 'pending';
            }
            
            $row->name = $data['name'];
            $row->email = $data['email'];
            $row->phone = $data['phone'];
            $row->city = $data['city'];
            $row->destination = $data['destination'];
            $row->duration = $data['duration'];
            $row->person_types = $data['person_types'];
            $row->approx_date = $data['approx_date'];
            $row->labels = isset($data['labels']) ? $data['labels'] : '';
            $row->assign_to = Auth::id();
            // if(!empty(addLeadRuno($row))){
            //     $row->is_runo_api = 1;
            // }
            
            $row->save();
            
            if(empty($data['id'])){
                return redirect()->back()->with('success', __('Lead Add Successfully '));
            }else{
            return 1;
            }
        }
    }
    public function campagin(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $mobileNos = json_decode($data['mobile_nos'], true);
            if(!empty($data['mobile_nos']) && count($mobileNos) > 0){
                $fileName = "";
                if($request->hasFile('file')) {
                    $file = $request->file('file');
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
                    $path = asset($destinationPath.$fileName);
                }
                
                $msg = $data['content'];

                $postData = ['mobileno'=>implode(",",$mobileNos), 'message'=>$msg,'file'=>null];
                if(!empty($fileName)){
                    $postData['file'] = $path;
                }
                $result = sendWhatsappBulkMsg($postData);
                
           
                // foreach ($mobileNos as $key => $phone) {
                //     $lead = Enquiry::where('phone', 'LIKE', '%'.$phone.'%')->WhereNotNull('name')->first();
                //     $msg = "Hi ".@$lead->name."%0a";
                //     $msg .= $data['content'];
                //     sleep(20);
                //     if($data['mobile_nos']){
                //         $to = (string)PhoneNumber::make($phone)->ofCountry('IN');
                //         if(!empty($fileName)){
                //             Sms::to($to)->content($msg)->file($path)->send();
                //         }else{
                //             Sms::to($to)->content($msg)->send();
                //         }
                //     }
                // }

                $row = new Campaign();
                $row->phone = json_encode($mobileNos);
                $row->content = $data['content'];
                $row->file = $fileName;
                $row->save();
            }
            
            
            return redirect()->back()->with('success', __('Campaign Successfully Run '));
        }
    }
    public function switchTab(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            
            $history = LeadHistory::where('phone',  $data['phone'])->orderBy('id','DESC')->get();
            $reminders = LeadReminder::where('phone', $data['phone'])->orderBy('id','DESC')->get();
            $whatsappchat=Conversation::select('id','to_id','from_id','message','created_at')->where('mobileno',$data['phone'])->orderBy('wp_id', 'desc')->get();
            $row = Enquiry::find($data['id']);
            
            // foreach ($reminders as $key => $row) {
            //     if($row->status){
            //         $enquiry = Enquiry::find($row->enquiry_id);
            //         $message = 'Name:'.''.$enquiry->name.'<br>'.$row->content.'<br>'. date('d-m-Y h:i A',strtotime($row->date)).'<br>'.$row->phone;
    
            //         $detail = array('to' =>'rinkumahawar9@gmail.com','subject'=>'TNG Reminder','content'=>$message);
            //         $datas = ['detail'=>$detail];
            //         try{
            //             Mail::send('Lead::emails.mail', $datas, function( $message ) use ($detail)
            //             {
            //               $message->to($detail['to'])->subject($detail['subject']);
            //             });
            //         }
            //         catch(\Exception $e){
            //             // $success = false;
            //             dd($e);
            //         }
            //     }
            // }
            
            $data = [
                'row' => $row,
                'tab' => $data['tab'],
                'history' => $history,
                'reminders' => $reminders,
                'whatsappchat' => $whatsappchat
            ];
            return view('Lead::admin.ajex-tab', $data);
        }
    }
    public function leadMailSend(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();


             if(isset($data['emails']) && count($data['emails']) > 0){
                $success = true;
                $row = new LeadEmail();
                
                foreach ($data['emails'] as $key => $email) {

                    $detail = array('to' =>$email,'subject'=>$data['subject'],'content'=>$data['content']);
                    $datas = ['detail'=>$detail];
                    
                    try{
                        Mail::send('Lead::emails.mail', $datas, function( $message ) use ($detail, $request)
                        {
                           $message->to($detail['to'])->subject($detail['content']);
                           if($request->hasFile('file')) {
                               $file = $request->file('file');
                                $message->attach($file->getRealPath(), array(
                                    'as' => $file->getClientOriginalName(), // If you want you can chnage original name to custom name      
                                    'mime' => $file->getMimeType())
                                );
                           }
                        });
                    }

                    catch(\Exception $e){
                        // $success = false;
                        // dd($e);
                    }
                }
                if ($success) {
                    $fileName = "";
                    if($request->hasFile('file')) {
                        $file = $request->file('file');
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
                    }
                    $lead = Enquiry::find($data['id']);
                    $row->fill($request->input());
                    $row->enquiry_id = $lead->id;
                    $row->phone = $lead->phone;
                    $row->attachment = $fileName;
                    $row->status = 'sent';
                    $row->save();

                    $history = new LeadHistory();
                    $history->enquiry_id = $lead->id;
                    $history->phone = $lead->phone;
                    $history->content = $row->subject;
                    $history->type = 'email';
                    $history->save();
                }
            }
            return 1;
        }
    }
    public function leadComment(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (!empty($data['content'])) {
                $lead = Enquiry::find($data['id']);
                $row = new LeadComment();
                $row->fill($request->input());
                $row->enquiry_id = $lead->id;
                $row->phone = $lead->phone;
                $row->status = 'publish';
                $row->save();
                
                if($data['type'] == 2 && !empty($lead->phone)){
                    $to = (string)PhoneNumber::make($lead->phone)->ofCountry('IN');
                    $fileName = "";
                    if($request->hasFile('file')) {
                        $file = $request->file('file');
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
                        $path = asset($destinationPath.$fileName);
                    }
                    if (!empty($fileName)) {
                        Sms::to($to)->content($data['content'])->file($path)->send();
                    }else{
                        Sms::to($to)->content($data['content'])->send();
                    }
                    
                }
                

                $history = new LeadHistory();
                $history->enquiry_id = $lead->id;
                $history->phone = $lead->phone;
                $history->content = $row->content;
                $history->type = ($data['type'] == 2) ? 'whatsapp' : 'comment';
                $history->save();
            }
            return 1;
        }
    }
    public function leadSetReminder(Request $request)
    {
        // if ($request->isMethod('post')) {
            $data = $request->all();
            if (!empty($data['content'])) {
                $lead = Enquiry::find($data['id']);
                $row = new LeadReminder();
                
                $date = str_replace("/", "-", $data['date']);
                
                $date = date('Y-m-d', strtotime($date));
                $time = date('H:i:s', strtotime($data['time']));
                $dateTime = $date.' '.$time;
                $row->fill($request->input());
                $row->date = $dateTime;
                $row->enquiry_id = $lead->id;
                $row->phone = $lead->phone;
                $row->status = 'publish';
                $row->save();

                $history = new LeadHistory();
                $history->enquiry_id = $lead->id;
                $history->phone = $lead->phone;
                $history->content = $row->content;
                $history->type = 'reminder';
                $history->save();
            }
            return 1;
        // }
    }
    public function index(Request $request)
    {
        // $leads = Enquiry::whereBetween('id', [700, 800])->orderBy('id', 'ASC')->get();
        // $dataArra = array();
        // $resultArra = array();
        // //foreach($leadss as $leads){
        //     foreach($leads as $row1)
        //       {    
        //           $dataArra = array();
        //           $phone = (string)PhoneNumber::make($row1->phone)->ofCountry('IN');
        //           $customer = array();
        //           $customer['name'] = (!empty($row1->name) ? $row1->name : null);
        //           $customer['phoneNumber'] = (!empty($phone) ? $phone : null);
        //           $customer['email'] = (!empty($row1->email) ? $row1->email : null);
                   
        //           $address = array(
        //               "street" => null,
        //               "city" => null,
        //               "state" => null,
        //               "country" => null,
        //               "pincode" => null,
        //               );
                    
        //           $persons = (int)(isset($row1->person_types[0]['name']) ? $row1->person_types[0]['number'] : 0);
        //           $persons += (int)(isset($row1->person_types[1]['name']) ? $row1->person_types[1]['number'] : 0);
        //           $persons += (int)(isset($row1->person_types[2]['name']) ? $row1->person_types[2]['number'] : 0);
        //           $kdm = array(
        //               "name" => (String)$persons,
        //               "phoneNumber" => (!empty($row1->approx_date) ? $row1->approx_date : null),
        //               );
        //           $customer['company']['name'] = null;
        //           $customer['company']['address'] = $address;
        //           $customer['company']['kdm'] = $kdm;
        //           $dataArra['customer'] = $customer;
        //           $dataArra['priority'] = -1;
        //           $dataArra['notes'] = null;
        //           $dataArra['processName'] = "Default Process";
        //           $dataArra['assignedTo'] = "+917823070707";
        //           $dataArra['userFields'] = null;
                
        //           $endpoint = "https://api.runo.in/v1/crm/allocation";
        //           $client = new \GuzzleHttp\Client(['headers' => ['Auth-Key' => 'dHh4bTk2eGJyMjRsMW00bA==']]);
        //           $response = $client->post($endpoint,  ['json'=> $dataArra]);
        //           $result = $response->getBody()->getContents();
        //           $resultArra[] = json_decode($result, true);
                  
                   
                   
        //     }
        // //}
        // dd($resultArra);
        // dd('done');
        
        
        $search = $request->query('search');
        $date_type = $request->query('date_type');
        $from_date = $request->query('from_date');
        $labels = $request->query('labels');
        $to_date = $request->query('to_date');
        $destination = $request->query('destination');
        $duration = $request->query('duration');
        $status = $request->query('status');
        $staffuser = $request->query('user');
        $file_type = $request->query('file_type');
        
         $params = array();
         if (empty($request->input('from_date')) && empty($request->input('to_date'))) {
             $params['from_date'] = date('d/m/Y', strtotime('-1 days', strtotime(date('Y-m-d'))));
             $params['to_date'] = date('d/m/Y');
             $params['date_type'] = 1;
             return redirect()->route('Lead.admin.index',$params)->withInput();
         }
         
             
        $q1 = Enquiry::with('AssignUser')->select('id','phone','labels','name','email','destination','approx_date','assign_to','created_at','updated_at')->where('status', '=', 'pending');
        $q2 = Enquiry::with('AssignUser')->select('id','phone','labels','name','email','destination','approx_date','assign_to','created_at','updated_at')->where('status', '=', 'processing');
        $q3 = Enquiry::with('AssignUser')->select('id','phone','labels','name','email','destination','approx_date','assign_to','created_at','updated_at')->where('status', '=', 'interested');
        $q4 = Enquiry::with('AssignUser')->select('id','phone','labels','name','email','destination','approx_date','assign_to','created_at','updated_at')->where('status', '=', 'quotation_send');
        $q5 = Enquiry::with('AssignUser')->select('id','phone','labels','name','email','destination','approx_date','assign_to','created_at','updated_at')->where('status', '=', 'completed');
        $q6 = Enquiry::with('AssignUser')->select('id','phone','labels','name','email','destination','approx_date','assign_to','created_at','updated_at')->where('status', '=', 'payment_done');
        $q7 = Enquiry::with('AssignUser')->select('id','phone','labels','name','email','destination','approx_date','assign_to','created_at','updated_at')->where('status', '=', 'cancel');
        $q8 = Enquiry::with('AssignUser')->select('id','phone','labels','name','email','destination','approx_date','assign_to','created_at','updated_at')->where('status', '=', 'notinterested');
        if (!empty($status)) {
            $q1->where('status', $status);
            $q2->where('status', $status);
            $q3->where('status', $status);
            $q4->where('status', $status);
            $q5->where('status', $status);
            $q6->where('status', $status);
            $q7->where('status', $status);
            $q8->where('status', $status);
        }
        if (!empty($labels)) {
            $q1->where('labels', 'LIKE', '%'.$labels.'%');
            $q2->where('labels', 'LIKE', '%'.$labels.'%');
            $q3->where('labels', 'LIKE', '%'.$labels.'%');
            $q4->where('labels', 'LIKE', '%'.$labels.'%');
            $q5->where('labels', 'LIKE', '%'.$labels.'%');
            $q6->where('labels', 'LIKE', '%'.$labels.'%');
            $q7->where('labels', 'LIKE', '%'.$labels.'%');
            $q8->where('labels', 'LIKE', '%'.$labels.'%');
        }
        if (!empty($search)) {
            if(is_numeric($search)){
                
                $q1->where('phone', 'LIKE', '%'.$search);
                $q2->where('phone', 'LIKE', '%'.$search);
                $q3->where('phone', 'LIKE', '%'.$search);
                $q4->where('phone', 'LIKE', '%'.$search);
                $q5->where('phone', 'LIKE', '%'.$search);
                $q6->where('phone', 'LIKE', '%'.$search);
                $q7->where('phone', 'LIKE', '%'.$search);
                $q8->where('phone', 'LIKE', '%'.$search);
            }else{
                $q1->where('name', 'LIKE', '%'.$search.'%');
                $q2->where('name', 'LIKE', '%'.$search.'%');
                $q3->where('name', 'LIKE', '%'.$search.'%');
                $q4->where('name', 'LIKE', '%'.$search.'%');
                $q5->where('name', 'LIKE', '%'.$search.'%');
                $q6->where('name', 'LIKE', '%'.$search.'%');
                $q7->where('name', 'LIKE', '%'.$search.'%');
                $q8->where('name', 'LIKE', '%'.$search.'%');
            }
        }
        if (!empty($from_date) && $date_type == 1) {
            $from_date = str_replace("/", "-", $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));
            
            $q1->whereDate('created_at','>=', $from_date);
            $q2->whereDate('created_at','>=', $from_date);
            $q3->whereDate('created_at','>=', $from_date);
            $q4->whereDate('created_at','>=', $from_date);
            $q5->whereDate('created_at','>=', $from_date);
            $q6->whereDate('created_at','>=', $from_date);
            $q7->whereDate('created_at','>=', $from_date);
            $q8->whereDate('created_at','>=', $from_date);
        }
        if (!empty($to_date) && $date_type == 1) {
            $to_date = str_replace("/", "-", $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));
            
            $q1->whereDate('created_at','<=', $to_date);
            $q2->whereDate('created_at','<=', $to_date);
            $q3->whereDate('created_at','<=', $to_date);
            $q4->whereDate('created_at','<=', $to_date);
            $q5->whereDate('created_at','<=', $to_date);
            $q6->whereDate('created_at','<=', $to_date);
            $q7->whereDate('created_at','<=', $to_date);
            $q8->whereDate('created_at','<=', $to_date);
            
        }
        if (!empty($from_date) && $date_type == 2) {
            $from_date = str_replace("/", "-", $from_date);
            $from_date = date('Y-m-d', strtotime($from_date));
            
            $q1->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'>=', $from_date);
            $q2->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'>=', $from_date);
            $q3->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'>=', $from_date);
            $q4->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'>=', $from_date);
            $q5->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'>=', $from_date);
            $q6->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'>=', $from_date);
            $q7->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'>=', $from_date);
            $q8->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'>=', $from_date);
        }
        if (!empty($to_date) && $date_type == 2) {
            $to_date = str_replace("/", "-", $to_date);
            $to_date = date('Y-m-d', strtotime($to_date));
            
            $q1->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'<=', $to_date);
            $q2->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'<=', $to_date);
            $q3->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'<=', $to_date);
            $q4->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'<=', $to_date);
            $q5->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'<=', $to_date);
            $q6->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'<=', $to_date);
            $q7->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'<=', $to_date);
            $q8->Where(DB::raw("STR_TO_DATE(approx_date,'%d/%m/%Y')"),'<=', $to_date);
 
            
        }
        
        if (!empty($destination)) {
            $q1->Where('destination', $destination);
            $q2->Where('destination', $destination);
            $q3->Where('destination', $destination);
            $q4->Where('destination', $destination);
            $q5->Where('destination', $destination);
            $q6->Where('destination', $destination);
            $q7->Where('destination', $destination);
            $q8->Where('destination', $destination);
            
        }
        if (!empty($duration)) {
            $q1->Where('duration', $duration);
            $q2->Where('duration', $duration);
            $q3->Where('duration', $duration);
            $q4->Where('duration', $duration);
            $q5->Where('duration', $duration);
            $q6->Where('duration', $duration);
            $q7->Where('duration', $duration);
            $q8->Where('duration', $duration);
            
        }
        if (!empty($staffuser)) {
            $q1->Where('update_user', $staffuser);
            $q2->Where('update_user', $staffuser);
            $q3->Where('update_user', $staffuser);
            $q4->Where('update_user', $staffuser);
            $q5->Where('update_user', $staffuser);
            $q6->Where('update_user', $staffuser);
            $q7->Where('update_user', $staffuser);
            $q8->Where('update_user', $staffuser);
            
        }
        
        $new_leads = $q1->orderBy('updated_at', 'desc')->get();
        $processing = $q2->orderBy('updated_at', 'desc')->get();
        $interested = $q3->orderBy('updated_at', 'desc')->get();
        $quotation_send = $q4->orderBy('updated_at', 'desc')->get();
        $complete_leads = $q5->orderBy('updated_at', 'desc')->get();
        $payment_done = $q6->orderBy('updated_at', 'desc')->get();
        $cancel_leads = $q7->orderBy('updated_at', 'desc')->get();
        $notinterested = $q8->orderBy('updated_at', 'desc')->get();
        $ary1 = $new_leads->pluck('phone')->toArray();
        $ary2 = $processing->pluck('phone')->toArray();
        $ary3 = $interested->pluck('phone')->toArray();
        $ary4 = $quotation_send->pluck('phone')->toArray();
        $ary5 = $complete_leads->pluck('phone')->toArray();
        $ary6 = $payment_done->pluck('phone')->toArray();
        $ary7 = $notinterested->pluck('phone')->toArray();
        $mobile_nos = array_unique(array_merge($ary1,$ary2,$ary3,$ary4,$ary5,$ary6,$ary7));
        $locations = Location::select('id', 'name')->where("status","publish")->orderBy('id', 'desc')->get();
        $terms = Terms::select('id', 'name')->where("attr_id", 12)->orderBy('id', 'ASC')->get();
        $users = User::query()->orderBy('id','desc')->role('staff')->get();
        
        if(!empty($file_type) && $file_type == "excel")
        {
           // Define the Excel spreadsheet headers
           $dataArray[] = ['Leads Report'];
           $dataArray[] = ['Name','E-Mail','Phone','City','No. of Person','Destination','Duration','Adult','Child','Kid','Approx Date','Status','Source','Assigned','Last Acivity','Created at','Updated at'];
           // and append it to the payments array.
           foreach($new_leads as $row1)
           {
               $dataArray[] = array(
               (!empty($row1->name) ? $row1->name : ''),
               (!empty($row1->email) ? $row1->email : ''),
               (!empty($row1->phone) ? $row1->phone : ''),
               (!empty($row1->city) ? $row1->city : ''),
               (!empty($row1->num_of_person) ? $row1->num_of_person : ''),
               (isset($row1->destination) ? @getLocationById(@$row1->destination)->name : ''),
               (isset($row1->duration) ? @getDurationById(@$row1->duration)->name : ''),
               (isset($row1->person_types[0]['name']) ? $row1->person_types[0]['number'] : ''),
               (isset($row1->person_types[1]['name']) ? $row1->person_types[1]['number'] : ''),
               (isset($row1->person_types[2]['name']) ? $row1->person_types[2]['number'] : ''),
               (isset($row1->approx_date) ? $row1->approx_date : '-'),
               (!empty($row1->status) ? $row1->status : ''),
               $row1->source,
               ((!empty($row1->update_user) && $row1->update_user != 1) ? @$row1->UpdateUser->first_name.' '.@$row1->UpdateUser->last_name : 'TNGHOLIDAYS'),
               $row1->getLastUserActivity(),
               $row1->created_at,
               $row1->updated_at,
              );
            }
            foreach($processing as $row1)
           {
               $dataArray[] = array(
               (!empty($row1->name) ? $row1->name : ''),
               (!empty($row1->email) ? $row1->email : ''),
               (!empty($row1->phone) ? $row1->phone : ''),
               (!empty($row1->city) ? $row1->city : ''),
               (!empty($row1->num_of_person) ? $row1->num_of_person : ''),
               (isset($row1->destination) ? @getLocationById(@$row1->destination)->name : ''),
               (isset($row1->duration) ? @getDurationById(@$row1->duration)->name : ''),
               (isset($row1->person_types[0]['name']) ? $row1->person_types[0]['number'] : ''),
               (isset($row1->person_types[1]['name']) ? $row1->person_types[1]['number'] : ''),
               (isset($row1->person_types[2]['name']) ? $row1->person_types[2]['number'] : ''),
               (isset($row1->approx_date) ? $row1->approx_date : '-'),
               (!empty($row1->status) ? $row1->status : ''),
               $row1->source,
               ((!empty($row1->update_user) && $row1->update_user != 1) ? @$row1->UpdateUser->first_name.' '.@$row1->UpdateUser->last_name : 'TNGHOLIDAYS'),
               $row1->getLastUserActivity(),
               $row1->created_at,
               $row1->updated_at,
              );
            }
            foreach($notinterested as $row1)
           {
               $dataArray[] = array(
               (!empty($row1->name) ? $row1->name : ''),
               (!empty($row1->email) ? $row1->email : ''),
               (!empty($row1->phone) ? $row1->phone : ''),
               (!empty($row1->city) ? $row1->city : ''),
               (!empty($row1->num_of_person) ? $row1->num_of_person : ''),
               (isset($row1->destination) ? @getLocationById(@$row1->destination)->name : ''),
               (isset($row1->duration) ? @getDurationById(@$row1->duration)->name : ''),
               (isset($row1->person_types[0]['name']) ? $row1->person_types[0]['number'] : ''),
               (isset($row1->person_types[1]['name']) ? $row1->person_types[1]['number'] : ''),
               (isset($row1->person_types[2]['name']) ? $row1->person_types[2]['number'] : ''),
               (isset($row1->approx_date) ? $row1->approx_date : '-'),
               (!empty($row1->status) ? $row1->status : ''),
               $row1->source,
               ((!empty($row1->update_user) && $row1->update_user != 1) ? @$row1->UpdateUser->first_name.' '.@$row1->UpdateUser->last_name : 'TNGHOLIDAYS'),
               $row1->getLastUserActivity(),
               $row1->created_at,
               $row1->updated_at,
              );
            }
            foreach($interested as $row1)
           {
               $dataArray[] = array(
               (!empty($row1->name) ? $row1->name : ''),
               (!empty($row1->email) ? $row1->email : ''),
               (!empty($row1->phone) ? $row1->phone : ''),
               (!empty($row1->city) ? $row1->city : ''),
               (!empty($row1->num_of_person) ? $row1->num_of_person : ''),
               (isset($row1->destination) ? @getLocationById(@$row1->destination)->name : ''),
               (isset($row1->duration) ? @getDurationById(@$row1->duration)->name : ''),
               (isset($row1->person_types[0]['name']) ? $row1->person_types[0]['number'] : ''),
               (isset($row1->person_types[1]['name']) ? $row1->person_types[1]['number'] : ''),
               (isset($row1->person_types[2]['name']) ? $row1->person_types[2]['number'] : ''),
               (isset($row1->approx_date) ? $row1->approx_date : '-'),
               (!empty($row1->status) ? $row1->status : ''),
               $row1->source,
               ((!empty($row1->update_user) && $row1->update_user != 1) ? @$row1->UpdateUser->first_name.' '.@$row1->UpdateUser->last_name : 'TNGHOLIDAYS'),
               $row1->getLastUserActivity(),
               $row1->created_at,
               $row1->updated_at,
              );
            }
            foreach($quotation_send as $row1)
           {
               $dataArray[] = array(
               (!empty($row1->name) ? $row1->name : ''),
               (!empty($row1->email) ? $row1->email : ''),
               (!empty($row1->phone) ? $row1->phone : ''),
               (!empty($row1->city) ? $row1->city : ''),
               (!empty($row1->num_of_person) ? $row1->num_of_person : ''),
               (isset($row1->destination) ? @getLocationById(@$row1->destination)->name : ''),
               (isset($row1->duration) ? @getDurationById(@$row1->duration)->name : ''),
               (isset($row1->person_types[0]['name']) ? $row1->person_types[0]['number'] : ''),
               (isset($row1->person_types[1]['name']) ? $row1->person_types[1]['number'] : ''),
               (isset($row1->person_types[2]['name']) ? $row1->person_types[2]['number'] : ''),
               (isset($row1->approx_date) ? $row1->approx_date : '-'),
               (!empty($row1->status) ? $row1->status : ''),
               $row1->source,
               ((!empty($row1->update_user) && $row1->update_user != 1) ? @$row1->UpdateUser->first_name.' '.@$row1->UpdateUser->last_name : 'TNGHOLIDAYS'),
               $row1->getLastUserActivity(),
               $row1->created_at,
               $row1->updated_at,
              );
            }
            foreach($complete_leads as $row1)
           {
               $dataArray[] = array(
               (!empty($row1->name) ? $row1->name : ''),
               (!empty($row1->email) ? $row1->email : ''),
               (!empty($row1->phone) ? $row1->phone : ''),
               (!empty($row1->city) ? $row1->city : ''),
               (!empty($row1->num_of_person) ? $row1->num_of_person : ''),
               (isset($row1->destination) ? @getLocationById(@$row1->destination)->name : ''),
               (isset($row1->duration) ? @getDurationById(@$row1->duration)->name : ''),
               (isset($row1->person_types[0]['name']) ? $row1->person_types[0]['number'] : ''),
               (isset($row1->person_types[1]['name']) ? $row1->person_types[1]['number'] : ''),
               (isset($row1->person_types[2]['name']) ? $row1->person_types[2]['number'] : ''),
               (isset($row1->approx_date) ? $row1->approx_date : '-'),
               (!empty($row1->status) ? $row1->status : ''),
               $row1->source,
               ((!empty($row1->update_user) && $row1->update_user != 1) ? @$row1->UpdateUser->first_name.' '.@$row1->UpdateUser->last_name : 'TNGHOLIDAYS'),
               $row1->getLastUserActivity(),
               $row1->created_at,
               $row1->updated_at,
              );
            }
            foreach($payment_done as $row1)
           {
               $dataArray[] = array(
               (!empty($row1->name) ? $row1->name : ''),
               (!empty($row1->email) ? $row1->email : ''),
               (!empty($row1->phone) ? $row1->phone : ''),
               (!empty($row1->city) ? $row1->city : ''),
               (!empty($row1->num_of_person) ? $row1->num_of_person : ''),
               (isset($row1->destination) ? @getLocationById(@$row1->destination)->name : ''),
               (isset($row1->duration) ? @getDurationById(@$row1->duration)->name : ''),
               (isset($row1->person_types[0]['name']) ? $row1->person_types[0]['number'] : ''),
               (isset($row1->person_types[1]['name']) ? $row1->person_types[1]['number'] : ''),
               (isset($row1->person_types[2]['name']) ? $row1->person_types[2]['number'] : ''),
               (isset($row1->approx_date) ? $row1->approx_date : '-'),
               (!empty($row1->status) ? $row1->status : ''),
               $row1->source,
               ((!empty($row1->update_user) && $row1->update_user != 1) ? @$row1->UpdateUser->first_name.' '.@$row1->UpdateUser->last_name : 'TNGHOLIDAYS'),
               $row1->getLastUserActivity(),
               $row1->created_at,
               $row1->updated_at,
              );
            }
            foreach($cancel_leads as $row1)
           {
               $dataArray[] = array(
               (!empty($row1->name) ? $row1->name : ''),
               (!empty($row1->email) ? $row1->email : ''),
               (!empty($row1->phone) ? $row1->phone : ''),
               (!empty($row1->city) ? $row1->city : ''),
               (!empty($row1->num_of_person) ? $row1->num_of_person : ''),
               (isset($row1->destination) ? @getLocationById(@$row1->destination)->name : ''),
               (isset($row1->duration) ? @getDurationById(@$row1->duration)->name : ''),
               (isset($row1->person_types[0]['name']) ? $row1->person_types[0]['number'] : ''),
               (isset($row1->person_types[1]['name']) ? $row1->person_types[1]['number'] : ''),
               (isset($row1->person_types[2]['name']) ? $row1->person_types[2]['number'] : ''),
               (isset($row1->approx_date) ? $row1->approx_date : '-'),
               (!empty($row1->status) ? $row1->status : ''),
               $row1->source,
               ((!empty($row1->update_user) && $row1->update_user != 1) ? @$row1->UpdateUser->first_name.' '.@$row1->UpdateUser->last_name : 'TNGHOLIDAYS'),
               $row1->getLastUserActivity(),
               $row1->created_at,
               $row1->updated_at,
              );
            }
             
             return Excel::download(new LeadExport($dataArray), 'leads.xlsx');
         }

        $data = [
            'locations'        => $locations,
            'terms'             => $terms,
            'new_leads'        => $new_leads,
            'processing'        => $processing,
            'interested'        => $interested,
            'notinterested'        => $notinterested,
            'quotation_send'        => $quotation_send,
            'complete_leads'        => $complete_leads,
            'payment_done'        => $payment_done,
            'cancel_leads'        => $cancel_leads,
            'mobile_nos'        => $mobile_nos,
            'staffs'             => $users,
            'page_title'=>__("Lead Management"),
            'breadcrumbs' => [
                [
                    'name' => __('Lead'),
                    'url'  => 'admin/module/Lead'
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ]
        ];

        return view('Lead::admin.index', $data);
    }

    public function create(Request $request)
    {
        $row = new Page();
        $row->fill([
            'status' => 'publish',
        ]);

        $data = [
            'row'         => $row,
            'translation'=>new Lead(),
            'page_title'=>__("Create Lead"),
            'breadcrumbs' => [
                [
                    'name' => __('Lead'),
                    'url'  => 'admin/module/Lead'
                ],
                [
                    'name'  => __('Add Lead'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Lead::admin.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $row = Lead::find($id);
        if (empty($row)) {
            return redirect('admin/module/Lead');
        }

        $data = [
            'row' =>$row,
            'page_title'=>__("Edit Lead"),
            'breadcrumbs' => [
                [
                    'name' => __('Lead'),
                    'url'  => 'admin/module/Lead'
                ],
                [
                    'name'  => __('Edit Lead'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Lead::admin.detail', $data);
    }
    public function delete(Request $request, $id)
    {

        $row = Lead::find($id);
        if (empty($row)) {
            return redirect('admin/module/Lead');
        }
        $row->delete_status = 0;
        $row->save();
        return back()->with('success',  __('Lead Deleted') );
    }

    public function store(Request $request, $id){

        if($id>0){
            $row = Lead::find($id);
            if (empty($row)) {
                return redirect(route('page.admin.index'));
            }
        }else{
            $row = new Lead();
        }

        $row->fill($request->input());
        if(!empty($request->input('expire_date'))){
            $expire_date = str_replace("/", "-", $request->input('expire_date'));
            $expire_date = date('Y-m-d', strtotime($expire_date));
            $row->expire_date = $expire_date;
        }

        $row->save();

        if($id > 0 ){
            return back()->with('success',  __('Lead updated') );
        }else{
            return redirect()->route('Lead.admin.edit',['id'=>$row->id])->with('success', $id > 0 ?  __('Lead updated') : __('Lead created'));
        }
    }
     public function leadInteractions(Request $request)
    {
       //$endpoint = "https://api.runo.in/v1/call/logs";
        $from_date = $request->query('from_date');
        $to_date = $request->query('to_date');
         if (!empty($request->input('from_date'))) {
             $from_date = str_replace("/", "-", $from_date);
             $from_date = date('Y-m-d', strtotime($from_date));
         }else{
             $from_date = date( "Y-m-d", strtotime(date('Y-m-d')." -1 day"));
         }
        $endpoint = "https://api.runo.in/v1/crm/interactions?date=$from_date&pageNo=1";
        $client = new \GuzzleHttp\Client(['headers' => ['Auth-Key' => 'dHh4bTk2eGJyMjRsMW00bA==']]);
        //2021-10-10
        // $dataArra = array('date'=>'2021-10-12','pageNo'=>2);
        $response = $client->get($endpoint);
        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        // if(count($result['data']['data'])){
        //     foreach($result['data']['data'] as $row1)
        //     {
        //         $status = array_column($row1['userFields'], 'value','name');
        //         $enquiry = Enquiry::where('phone',substr($row1['customer']['phoneNumber'], 3))->orderBy('id','DESC')->first();
        //         $dateTime = getArrayByVal($row1['userFields'], 'Appointment On');
        //         $content = getArrayByVal($row1['userFields'], 'Status');
        //         $reminderArray = array();
                
        //         if(empty($enquiry)){
                       //$adult = !empty($row1['customer']['company']['kdm']['name']) ? $row1['customer']['company']['kdm']['name'] : 0;
        //             $person_types = array(['name'=>'Adult','number'=>$adult],['name'=>'Child','number'=>0],['name'=>'Kid','number'=>0]);
        //             $enquiry = new Enquiry();
        //             $enquiry->status = 'pending';
        //             $enquiry->name = $row1['customer']['name'];
        //             $enquiry->email = $row1['customer']['email'];
        //             $enquiry->phone = $row1['customer']['phoneNumber'];
        //             $enquiry->city = $row1['customer']['company']['address']['city'];
        //             $enquiry->destination = null;
        //             $enquiry->duration = null;
        //             $enquiry->person_types = $person_types;
                    
        //             $enquiry->labels = ((count($status) > 0) ? array(getAllLabel($status['Status'])) : '');
        //             $enquiry->is_runo_api = 1;
        //         }
        //         $enquiry->approx_date = $row1['customer']['company']['kdm']['phoneNumber'];
        //         $enquiry->save();
        //         if(!empty($dateTime)){
        //             $reminderArray['date'] = date('d/m/Y', $dateTime['value']);
        //             $reminderArray['time'] = date('h:i:s', $dateTime['value']);
        //             $reminderArray['content'] = $content['value'];
        //             $reminderArray['id'] = $enquiry->id;
        //             $request->merge($reminderArray);
                    
        //         }
        //         if(count($reminderArray) > 0){
        //             $this->leadSetReminder($request);
        //         }
        //     }
        // }
        
        // dd($result);
        return view('Lead::admin.leadinteractions',compact('result'));
    }
    public function leadCallLogs(Request $request)
    {
        
        $from_date = $request->query('from_date');
        $to_date = $request->query('to_date');
         if (!empty($request->input('from_date'))) {
             $from_date = str_replace("/", "-", $from_date);
             $from_date = date('Y-m-d', strtotime($from_date));;
         }else{
             $from_date = date( "Y-m-d", strtotime(date('Y-m-d')." -1 day"));
         }
        $endpoint = "https://api.runo.in/v1/call/logs?date=$from_date&pageNo=1";
        $client = new \GuzzleHttp\Client(['headers' => ['Auth-Key' => 'dHh4bTk2eGJyMjRsMW00bA==']]);
        
        // $dataArra = array('date'=>$from_date,'pageNo'=>1);
        $response = $client->get($endpoint);
        $result = $response->getBody()->getContents();
        $result = json_decode($result, true);
        return view('Lead::admin.call-logs',compact('result'));
    }
}
