<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Lead\Models\LeadReminder;
use Modules\Booking\Models\Enquiry;
    use Propaganistas\LaravelPhone\PhoneNumber;
  use Modules\Sms\Core\Facade\Sms;
    use App\Notifications\AdminChannelServices;
  use Mail;
    use App\User;

class DailyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send Reminder by E-Mail and SMS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    
    public function handle()
    {
        $today = date('Y-m-d H:i:s',strtotime("-1 minutes"));
             $plusOneMinut = date('Y-m-d H:i:s');
        $reminders = LeadReminder::whereBetween('date', [$today, $plusOneMinut])->where('status','publish')->get();
        //  $reminders = LeadReminder::orderBy('id','DESC')->get();
         if (count($reminders)) {
            foreach ($reminders as $key => $row) {
                if($row->status == 'publish'){
                    $row->status = 'done';
                    $row->save();
                    $enquiry = Enquiry::find($row->enquiry_id);
                    $message = 'Name:'.''.@$enquiry->name.' '.@$row->content.' '. date('d-m-Y h:i A',strtotime(@$row->date)).' '.$row->phone;
                    
                    
                    $message2 = 'Reminder:- '.''.@$enquiry->name.', '.@$row->content.', '. date('d-m-Y h:i A',strtotime(@$row->date)).', '.$row->phone;
                    $data = [
                        'id' =>  @$row->id,
                        'event'=>'ReminderSendEvent',
                        'to'=>'admin',
                        'name' =>  'TNGHOLIDAYS',
                        'link' => '#',
                        'type' => 'reminder',
                        'message' =>$message2
                    ];
                    $vendor = User::find(1);
                    if($vendor){
                        $vendor->notify(new AdminChannelServices($data));
                        
                    }
                        
                    $to = (string)PhoneNumber::make('7823070707')->ofCountry('IN');
                    Sms::to($to)->content($message)->send();
                    
                    $message2 = 'Name:'.''.$enquiry->name.'<br>'.$row->content.'<br>'. date('d-m-Y h:i A',strtotime($row->date)).'<br>'.$row->phone;
                    $detail = array('to' =>'tngholidays@gmail.com','subject'=>'TNG Reminder','content'=>$message2);
                    $datas = ['detail'=>$detail];
                    try{
                        Mail::send('Lead::emails.mail', $datas, function( $message ) use ($detail)
                        {
                           $message->to($detail['to'])->subject($detail['subject']);
                        });
                    }
                    catch(\Exception $e){
                        // $success = false;
                        // dd($e);
                    }
                }
            }
         }
         
        $leads = Enquiry::where('is_runo_api', 0)->whereNotNull('name')->get();
        foreach($leads as $row1)
        {
            
            if(!empty(addLeadRuno($row1))){
                $row1->is_runo_api = 1;
                $row1->save();
            }
            
        }

        $this->info('Successfully sent daily reminder to everyone.');
    }
}
