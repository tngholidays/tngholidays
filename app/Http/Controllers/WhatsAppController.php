<?php
namespace App\Http\Controllers;

use App\User;
use Modules\Page\Models\Page;
use Modules\News\Models\NewsCategory;
use Modules\News\Models\Tag;
use Modules\News\Models\News;
use Modules\Location\Models\Location;
use Modules\Core\Models\Terms;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Whatsapp;
use App\ChatbotData;
    use Propaganistas\LaravelPhone\PhoneNumber;
  use Modules\Sms\Core\Facade\Sms;
//use DB;
class WhatsAppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $destination=array('Thailand','Maldives','Dubai','Goa');
    public $num=array('0️⃣','1️⃣','2️⃣','3️⃣','4️⃣','5️⃣','6️⃣','7️⃣','8️⃣','9️⃣');
    public $thailanddestination=array('Pattaya','Bangkok and Pattaya','Phuket','Phuket and Krabi','Phuket, Krabi and Bangkok','Pattaya, Phuket and Krabi','Pattaya, Phuket-Krabi-Bangkok');
    public $duration=array('3 Night 4 Days','4 Night 5 Day','5 Night 6 Day','6 Night 7 Day','7 Night 8 Days','8 Night 9 Days');
    public $adult=array('2 Adult','3 Adult','4 Adult','5 Adult','6 Adult','7-12 Adult');
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function uk()
    {
      $data = file_get_contents('https://crm.bigtos.com/home/uk');

     $data=json_decode($data);

     if(!empty($data))
     {

        $lead_id=DB::table('bravo_enquiries')->where('subscribe_id',trim($data->subscribe_id))->count();
       // die();
         if($lead_id==0 && @$data->mobileno!='')
         {


             $duration='';
             $destination=@$data->city;
             $city='';
             $adult = (int)$data->adult;
            $child = (int)$data->child;
            $kids = (int)$data->kids;

            $persons = (is_numeric($adult) ? $adult : 0);
            $persons += (is_numeric($child) ? $child : 0);
            $persons += (is_numeric($kids) ? $kids : 0);
             $msg = 'Thanks for Enquiry about'.'%0a Destination: '.$destination.'%0a Duration: '.$data->Duration.'%0a No. of Person: '.$persons.'%0a Approx Journey Date: '.@$data->Date.'%0aWe will get back soon with best quotation. for more call on 7823070707';
            if($data->Duration!="")
             {

                  $data->Duration=str_replace('N',' Night', $data->Duration);
                  $data->Duration=str_replace('D',' Day', $data->Duration);
                  $data->Duration=str_replace('/',' ', $data->Duration);
                 $terms=DB::table('bravo_terms')->where('name', 'LIKE', '%'.trim($data->Duration).'%')->where('deleted_at',null)->first();
                 if($terms)
                 {
                     $duration=$terms->id;
                 }


             }

            if($destination!="")
            {
                if($destination=='Thailand')
                {
                    $destination=$city;
                }
                $location=DB::table('bravo_locations')->where('name',trim($destination))->where('deleted_at',null)->first();
                if($location)
                {
                    $destination=$location->id;
                }



            }

            $person_type='[{"name":"Adult","number":"'.(int)$data->adult.'"},{"name":"Child","number":"'.(int)$data->child.'"},{"name":"Kid","number":"'.(int)$data->kids.'"}]';

          echo $lead_id=DB::table('bravo_enquiries')->insertGetId([
               'object_model' => 'tour',
               'name' => @$data->name,
               'phone'=>@$data->mobileno,
               'subscribe_id'=>@$data->subscribe_id,
               'city'=>$city,
               'approx_date'=>$data->Date,
               'num_of_person'=>(int)$data->adult,
               'destination'=>(int)$destination,
               'duration'=>(int)$duration,
               'object_id'=>0,
               'vendor_id'=>1,
               'status'=>'pending',
               'create_user'=>'1',
               'person_types'=>$person_type,
               'create_user'=>'1',
               'source'=>'Facebook',
             //  'person_types'=>$person_type,
               'created_at'=>date("Y-m-d H:i:s"),
               'updated_at'=>date("Y-m-d H:i:s"),
           ]);

           //send whatsapp thanks msg
           $to = (string)PhoneNumber::make($data->mobileno)->ofCountry('IN');
            Sms::to($to)->content($msg)->send();

         }
     }



      //  $this->enquery(1);
    }
    private function enquery($id)
    {


        $whatappdata=Whatsapp::where('id',$id)->first();

        if($whatappdata->lead_id==0)
        {
            $destination=$this->getdata($id,'Destination');
            $duration=$this->getdata($id,'Duration');
            $adult=$this->getdata($id,'Adult');
            $child=$this->getdata($id,'Child');
            $kids=$this->getdata($id,'Kids');
            $date=$this->getdata($id,'Travel Date');
            $city=$this->getdata($id,'City');

            if($destination!="")
            {
                if($destination=='Thailand')
                {
                    $destination=$city;

                }

                $data=DB::table('bravo_locations')->where('name',trim($destination))->where('deleted_at',null)->first();
                if($data)
                {
                    $destination=$data->id;
                }


            }
            if($duration!="")
            {
                $data=DB::table('bravo_terms')->where('name', 'LIKE', '%'.trim($duration).'%')->where('deleted_at',null)->first();
                if($data)
                {
                    $duration=$data->id;
                }


            }

            $person_type='[{"name":"Adult","number":"'.(int)$adult.'"},{"name":"Child","number":"'.(int)$child.'"},{"name":"Kid","number":"'.(int)$kids.'"}]';

            $lead_id=DB::table('bravo_enquiries')->insertGetId([
                'object_model' => 'tour',
                'name' => @$whatappdata->name,
                'phone'=>@$whatappdata->mobile,
             //   'city'=>$city,
               // 'approx_date'=>$date,
               // 'num_of_person'=>(int)$adult,
               // 'destination'=>(int)$destination,
               // 'duration'=>(int)$duration,
                'object_id'=>0,
                'vendor_id'=>1,
                'status'=>'pending',
                'create_user'=>'1',
              //  'person_types'=>$person_type,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s"),
            ]);

            Whatsapp::where('id',$id)->update(['lead_id'=>$lead_id]);

        }
        else
        {
            $destination=$this->getdata1($whatappdata->lead_id,'Destination');
            $duration=$this->getdata1($whatappdata->lead_id,'Duration');
            $adult=$this->getdata1($whatappdata->lead_id,'Adult');
            $child=$this->getdata1($whatappdata->lead_id,'Child');
            $kids=$this->getdata1($whatappdata->lead_id,'Kids');
            $date=$this->getdata1($whatappdata->lead_id,'Travel Date');
            $city=$this->getdata1($whatappdata->lead_id,'City');

            if($destination!="")
            {
                 $maindestination='';
                if($destination=='Thailand')
                {
                    $maindestination=$destination;
                    $destination=$city;
                    $city="";

                }

                $data=DB::table('bravo_locations')->where('name',trim($destination))->where('deleted_at',null)->first();
                if($data)
                {
                    $destination=$data->id;
                }
              //  $tt['args']=array('to'=>'9950448844','content'=>$destination.$city.$destination);
                // Whatsapp::Send('Text',$tt);

            }
            if($duration!="")
            {
                $data=DB::table('bravo_terms')->where('name', 'LIKE', '%'.trim($duration).'%')->where('deleted_at',null)->first();
                if($data)
                {
                    $duration=$data->id;
                }


            }

            $person_type='[{"name":"Adult","number":"'.(int)$adult.'"},{"name":"Child","number":"'.(int)$child.'"},{"name":"Kid","number":"'.(int)$kids.'"}]';

            DB::table('bravo_enquiries')->where("id",$whatappdata->lead_id)->update([
                'object_model' => 'tour',
                'name' => @$whatappdata->name,
                'phone'=>@$whatappdata->mobile,
                'city'=>$city,
                'approx_date'=>$date,
                'num_of_person'=>(int)$adult,
                'destination'=>(int)$destination,
                'duration'=>(int)$duration,
                'object_id'=>0,
                'vendor_id'=>1,
                'status'=>'pending',
                'create_user'=>'1',
                'person_types'=>$person_type,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s"),
            ]);
        }

      // echo $destination;die("OK");



    }

    public function getdata1($id,$question)
    {
        $msg='';
        $data=ChatbotData::where('lead_id',$id)->where('question',$question)->first();
        if(!empty($data))
        {
           $msg=$data->answer;
        }

      return $msg;
    }
    public function getdata($id,$question)
    {
        $msg='';
        $data=ChatbotData::where('wa_id',$id)->where('question',$question)->orderBy('id','desc')->first();
        if(!empty($data))
        {
           $msg=$data->answer;
        }

      return $msg;
    }
    public function index(Request $request)
    {
           $input =Input::all();
           $request=(object)json_decode($input['data']);
           $output=array();
           $result='';

           if($request->event=='message')
           {

               $message=(object)$request->data;

               if($message->type=='chat')
               {
                   $result=$this->start($message);
                   if($result['status'])
                   {
                            $mobileno=(int)$message->chatId;
                           $output['args']=array('to'=>$mobileno,'content'=>$result['data']);
                           Whatsapp::Send('Text',$output);
                           if($result['update']=='1.7')
                           {
                               Whatsapp::where('username',$message->chatId)->update(['command'=>'1.7']);

                           }
                           if(substr_count($result['data'],'Thanks for Enquiry about'))
                           {
                             Whatsapp::where('username',$data->chatId)->update(['command'=>'9','lead_id'=>0]);
                           }
                           //  $tt['args']=array('to'=>'9950448844','content'=>json_encode($result));
                            // Whatsapp::Send('Text',$tt);

               }
                  // mail("un@unv7.com","demo",json_encode($result));
               }
            }
           //mail('un@unv7.com','welcomedemo',json_encode($request));
    }

    private function start($data)
    {
        $output=array();
        $input=array();
        $temp=true;
        $todo='';
        $message=@$data->body;
        $condtion=null;;
        $output['update']=0;

        try{
            if(substr_count(strtolower($message), 'thailand'))
            {
                Whatsapp::DataInsert($data);
                $message=0;
            }
            else
            {
                if(substr_count(strtolower($message), 'maldives'))
                {
                   Whatsapp::DataInsert($data);
                    $message=1;
                   /// Whatsapp::where('username',$data->chatId)->update(['command'=>'2']);
                }
                elseif(substr_count(strtolower($message), 'dubai'))
                {
                  Whatsapp::DataInsert($data);
                   $message=2;
                   //Whatsapp::where('username',$data->chatId)->update(['command'=>'3']);
                }
                elseif(substr_count(strtolower($message), 'goa'))
                {
                   // mail('un@unv7.com',"datafinanl", $message);

                   $message=3;

                   Whatsapp::DataInsert($data);
                   //Whatsapp::where('username',$data->chatId)->update(['command'=>'4']);
                }


            }

            if(is_numeric($message))
            {
                $condtion=$message;
                if($message=='9')
                {
                    Whatsapp::where('username',$data->chatId)->update(['command'=>'9','lead_id'=>'0']);
                }

                $whatappdata=Whatsapp::where('username',$data->chatId)->first();

                if($whatappdata)
                {
                    if($whatappdata->command!=9)
                    {
                        $condtion=$whatappdata->command;
                        $maincommand=$whatappdata->command;
                    }
                    else
                    {
                        if($message > 0 && $message!=9)
                        {
                            $this->enquery($whatappdata->id);
                            $whatappdata=Whatsapp::where('username',$data->chatId)->first();
                            $condtion='1.1';
                            $obj = new ChatbotData();
                             $obj->wa_id= $whatappdata->id;
                             $obj->lead_id=$whatappdata->lead_id;
                             $obj->question='Destination';
                             $obj->answer=@$this->destination[$message];
                             $obj->save();

                            $mobileno=explode('@', $data->chatId);
                            $mobileno=substr($mobileno[0],2);
                        }
                    }
                }

                $whatappdata=Whatsapp::where('username',$data->chatId)->first();
                if($condtion=='1.1')
                {

                    if($message > 6  && $message < 9)
                    {
                        $output['data']="Please choose the Correct Answer Between 0 to 6\nकृपया 0 से 6 के बीच सही उत्तर चुनें";
                        $temp=false;
                    }

                }
                elseif($condtion=='1.2'|| $condtion=='1.3')
                {

                    if($message > 5  && $message < 9)
                      {
                           $output['data']="Please choose the Correct Answer Between 0 to 5\nकृपया 0 से 5 के बीच सही उत्तर चुनें";
                           $temp=false;
                       }
                }
                elseif($condtion=='1.4'|| $condtion=='1.5')
                {

                    if($message > 4  && $message < 9)
                      {
                           $output['data']="Please choose the Correct Answer Between 0 to 4\nकृपया 0 से 4 के बीच सही उत्तर चुनें";
                           $temp=false;
                       }
                }
               elseif($condtion=='1.6')
               {

                   if(is_numeric($message))
                     {
                          $output['data']="Please enter correct date formate (Example 1/10/2021 )\nकृपया सही तिथि प्रारूप दर्ज करें (उदाहरण 1/10/2021 )";
                          $temp=false;
                      }
               }
               elseif($condtion=='1.7')
               {

                      if(is_numeric($message))
                        {
                             $output['data']="Please enter your name \nकृपया अपना नाम दर्ज करें";
                             $temp=false;
                         }
               }
               else{
                   if($message > 3 && $message < 9)
                   {
                       $output['data']="Please choose the Correct Answer Between 0 to 3\nकृपया 0 से 3 के बीच सही उत्तर चुनें";
                        $temp=false;
                   }
                    //  $tt['args']=array('to'=>'9950448844','content'=>$message);
                     // Whatsapp::Send('Text',$tt);
               }
              //die();
                if($temp)
                {
                    Whatsapp::DataInsert($data);
                    $whatappdata=Whatsapp::where('username',$data->chatId)->first();
                switch ($condtion) {
                    case 0:
                        if($message==0)
                        {
                             $obj = new ChatbotData();
                             $obj->wa_id=@$whatappdata->id;
                             $obj->lead_id=@$whatappdata->lead_id;
                             $obj->question='Destination';
                             $obj->answer=@$this->destination[$message];
                             $obj->save();

                            $mobileno=explode('@', $data->chatId);
                            $mobileno=substr($mobileno[0],2);



                            $msg="Which City Your want to Travel. (Example for Pattaya Type 0)\nआप किस शहर की यात्रा करना चाहते हैं। (उदहारण के लिए अगर पटाया जाना है तो टाइप करे 0)\n";
                            foreach($this->thailanddestination as $key=>$val)
                            {
                                $msg.="\n".$this->num[$key]."👉 ".$val;
                            }
                            $output['data']=$msg."\n\n9️⃣ 👉 Main Menu";
                            Whatsapp::where('username',$data->chatId)->update(['command'=>'1.1']);
                            //$output['data']="Enter Your Order No.";

                        }
                        else
                        {

                            //$output['data']=$msg."\n\n9️⃣ 👉 Main Menu";
                        }
                        break;
                    case 1.1:
                        //if($whatappdata->command ==1)
                        {
                         $obj = new ChatbotData();
                         $obj->wa_id= $whatappdata->id;
                         $obj->lead_id=$whatappdata->lead_id;
                         $obj->question='City';
                         $obj->answer=@$this->thailanddestination[(int)$message];
                         $obj->save();
                        }
                        $msg="Duration of Travel Package (Example for 3Nights 4 Days Type 0)\nयात्रा पैकेज की अवधि (उदाहरण के लिए अगर 3 रातें 4 दिन टाइप करे  0)\n";
                         foreach($this->duration as $key=>$val)
                         {
                             $msg.="\n".$this->num[$key]."👉 ".$val;
                         }
                        $output['data']=$msg."\n\n9️⃣ 👉 Main Menu";
                        Whatsapp::where('username',$data->chatId)->update(['command'=>'1.2']);
                        break;
                    case 1.2:
                         $obj = new ChatbotData();
                         $obj->wa_id= $whatappdata->id;
                         $obj->lead_id=$whatappdata->lead_id;
                         $obj->question='Duration';
                         $obj->answer=@$this->duration[(int)$message];
                         $obj->save();
                        $msg="How Many Adult  want to travel\nकितने वयस्क यात्रा करना चाहते हैं\n";
                         foreach($this->adult as $key=>$val)
                         {
                             $msg.="\n".$this->num[$key]."👉 ".$val;
                         }
                        $output['data']=$msg."\n\n9️⃣ 👉 Main Menu";
                        Whatsapp::where('username',$data->chatId)->update(['command'=>'1.3']);
                        break;
                    case 1.3:
                         $obj = new ChatbotData();
                         $obj->wa_id= $whatappdata->id;
                         $obj->lead_id=$whatappdata->lead_id;
                         $obj->question='Adult';
                         $obj->answer=@$this->adult[(int)$message];
                         $obj->save();
                        $msg="How Many Child want to travel \nकितने बच्चे यात्रा करना चाहते हैं\n";
                        for($i=0;$i!=5;$i++)
                         {
                             $msg.="\n".$this->num[$i]."👉 ".$i." Child";
                         }
                        $output['data']=$msg."\n\n9️⃣ 👉 Main Menu";
                        Whatsapp::where('username',$data->chatId)->update(['command'=>'1.4']);
                        break;
                    case 1.4:
                         $obj = new ChatbotData();
                         $obj->wa_id= $whatappdata->id;
                         $obj->lead_id=$whatappdata->lead_id;
                         $obj->question='Child';
                         $obj->answer=$message;
                         $obj->save();
                        $msg="How Many Kids want to travel\nकितने शिशु यात्रा करना चाहते हैं\n";
                        for($i=0;$i!=5;$i++)
                         {
                             if($i > 1)
                                $msg.="\n".$this->num[$i]."👉 ".$i." Kids";
                             else
                                $msg.="\n".$this->num[$i]."👉 ".$i." Kid";
                         }
                        $output['data']=$msg."\n\n9️⃣ 👉 Main Menu";
                        Whatsapp::where('username',$data->chatId)->update(['command'=>'1.5']);
                        break;
                    case 1.5:
                         $obj = new ChatbotData();
                         $obj->wa_id= $whatappdata->id;
                         $obj->lead_id=$whatappdata->lead_id;
                         $obj->question='Kids';
                         $obj->answer=$message;
                         $obj->save();
                        $msg="Approx Travel Date and Month(Example 1/10/2021)\nअनुमानित यात्रा तिथि और माह (उदाहरण 1/10/2021)\n";
                        $output['data']=$msg;
                        Whatsapp::where('username',$data->chatId)->update(['command'=>'1.6']);
                        break;
                    case 1.6:
                         $obj = new ChatbotData();
                         $obj->wa_id= $whatappdata->id;
                         $obj->lead_id=$whatappdata->lead_id;
                         $obj->question='Travel Date';
                         $obj->answer=$message;
                         $obj->save();


                         $output['data']="What is your name?";
                        Whatsapp::where('username',$data->chatId)->update(['command'=>'1.7']);
                        break;
                    case 9:
                        $output['data']=$this->WelcomeMessage($data);
                        break;
                    default:
                        $output['data']=$this->WelcomeMessage($data);
                }
                $this->enquery($whatappdata->id);
                }
            }
            else
            {

                $condtion=$message;
                $username=@$data->chatId;
                $whatappdata=Whatsapp::where('username',$username)->first();
                if($whatappdata)
                {
                    if($whatappdata->command=='1.6')
                    {

                         $obj = new ChatbotData();
                         $obj->wa_id= $whatappdata->id;
                         $obj->lead_id=$whatappdata->lead_id;
                         $obj->question='Travel Date';
                         $obj->answer=$message;
                         $obj->save();
                         $output['data']="What is your name?";
                         $output['update']='1.7';

                    }
                    elseif($whatappdata->command=='1.7')
                    {
                        Whatsapp::where('username',$data->chatId)->update(['name'=>$message]);
                        $destination=$this->getdata($whatappdata->id,'Destination');
                        $duration=$this->getdata($whatappdata->id,'Duration');
                        $adult=$this->getdata($whatappdata->id,'Adult');
                        $child=$this->getdata($whatappdata->id,'Child');
                        $kids=$this->getdata($whatappdata->id,'Kids');
                        $date=$this->getdata($whatappdata->id,'Travel Date');
                        $adult = (int)$adult;
                        $child = (int)$child;
                        $kids = (int)$kids;

                        $persons = (is_numeric($adult) ? $adult : 0);
                        $persons += (is_numeric($child) ? $child : 0);
                        $persons += (is_numeric($kids) ? $kids : 0);
                        $date=$this->getdata($whatappdata->id,'Travel Date');


                        $msg = 'Thanks for Enquiry about'.'%0a Destination: '.$destination.'%0a Duration: '.$duration.'%0a No. of Person: '.$persons.'%0a Approx Journey Date: '.@$date.'%0aWe will get back soon with best quotation. for more call on 7823070707';

                        $output['data']=$msg;
                        //"\n\n9️⃣ 👉 Main Menu";

                        $final=array();
                        $mobileno=(int)$data->chatId;
                        $final['args']=array('to'=>$mobileno,'content'=>"#0");
                         Whatsapp::Send('Text',$final);


                        $this->enquery($whatappdata->id);
                        //Whatsapp::where('username',$data->chatId)->update(['command'=>'9']);
                        Whatsapp::where('username',$data->chatId)->update(['command'=>'9','lead_id'=>0]);
                    }
                    elseif($whatappdata->command=='1.1')
                    {
                        $output['data']="Please choose the Correct Answer Between 0 to 6\nकृपया 0 से 6 के बीच सही उत्तर चुनें";
                    }
                    elseif($whatappdata->command=='1.2'||$whatappdata->command=='1.3')
                    {
                        $output['data']="Please choose the Correct Answer Between 0 to 5\nकृपया 0 से 5 के बीच सही उत्तर चुनें";
                    }
                    elseif($whatappdata->command=='1.4'||$whatappdata->command=='1.5')
                    {
                        $output['data']="Please choose the Correct Answer Between 0 to 4\nकृपया 0 से 4 के बीच सही उत्तर चुनें";
                    }

                    else
                    {
                        $output['data']=$this->WelcomeMessage($data);
                    }
                }
                else
               {
                   $output['data']=$this->WelcomeMessage($data);
               }

               }
        }catch (\Illuminate\Database\QueryException $e){

              $output['data']	= "Error IN Query : ".$e->getMessage();
          } catch (PDOException $e) {

              $output['data']	= "Error IN Query : ".$e->getMessage();
          } catch (\Exception $e) {

                 $output['data']	= $e->getMessage().'::::'.$e->getLine();
          }

        $output['status'] 		 = true;
        if($todo!='')
         $output['msg'] 			 = "order";
        else
          $output['msg'] 			 = '';


        return $output;
    }

    private function WelcomeMessage($data)
    {
        Whatsapp::DataInsert($data);
        Whatsapp::where('username',$data->chatId)->update(['command'=>'9']);
        $whatappdata=Whatsapp::where('username',$data->chatId)->first();
        $this->enquery($whatappdata->id);
        //Whatsapp::where('username',$data->chatId)->update(['command'=>'9','lead_id'=>0]);
        $name=@$data->sender->pushname;
        if($name=="")
        {
            $name=@$data->sender->name;
        }
        $whatappdata=Whatsapp::where('username',$data->chatId)->first();


        $msg= "Hi ".$name."\n*TNG Holidays* में आपका स्वागत है\n\nEnter any options Below Destination (Example for Thailand Type 0)\nगंतव्य के लिए नीचे से कोई भी विकल्प दर्ज करें (उदाहरण के लिए अगर आपको थाईलैंड जाना है तो टाइप करे 0)";
        foreach($this->destination as $key=>$val)
        {
            $msg.="\n".$this->num[$key]."👉 ".$val;
        }
        return $msg;
    }


}
