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

class runoDateUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updaterunolead:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Leads rom Runo API';

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
        $from_date = date( "Y-m-d", strtotime(date('Y-m-d')." -1 day"));
            $endpoint = "https://api.runo.in/v1/crm/interactions?date=$from_date&pageNo=1";
            $client = new \GuzzleHttp\Client(['headers' => ['Auth-Key' => 'dHh4bTk2eGJyMjRsMW00bA==']]);
            $response = $client->get($endpoint);
            $result = $response->getBody()->getContents();
            $result = json_decode($result, true);
            if(count($result['data']['data'])){
                foreach($result['data']['data'] as $row1)
                {
                    $status = array_column($row1['userFields'], 'value','name');
                    $enquiry = Enquiry::where('phone', 'LIKE', '%'.substr($row1['customer']['phoneNumber'], 3).'%')->orderBy('id','DESC')->first();
                    $dateTime = getArrayByVal($row1['userFields'], 'Appointment On');
                    $content = getArrayByVal($row1['userFields'], 'Status');
                    $reminderArray = array();
                    
                    if(empty($enquiry)){
                           $adult = !empty($row1['customer']['company']['kdm']['name']) ? $row1['customer']['company']['kdm']['name'] : 0;
                        $person_types = array(['name'=>'Adult','number'=>$adult],['name'=>'Child','number'=>0],['name'=>'Kid','number'=>0]);
                        $enquiry = new Enquiry();
                        $enquiry->status = 'pending';
                        $enquiry->name = $row1['customer']['name'];
                        $enquiry->email = $row1['customer']['email'];
                        $enquiry->phone = $row1['customer']['phoneNumber'];
                        $enquiry->city = $row1['customer']['company']['address']['city'];
                        $enquiry->destination = null;
                        $enquiry->duration = null;
                        $enquiry->person_types = $person_types;
                        
                        $enquiry->labels = ((count($status) > 0) ? array(getAllLabel($status['Status'])) : '');
                        $enquiry->is_runo_api = 1;
                    }
                    if(!empty($enquiry->labels) && !empty(getAllLabel($status['Status']))){
                        $enquiry->labels = ((count($enquiry->labels) > 0) ? array_push($enquiry->labels,getAllLabel($status['Status'])) : '');
                    }
                    
                    $enquiry->approx_date = $row1['customer']['company']['kdm']['phoneNumber'];
                    $enquiry->save();
                    if(!empty($dateTime)){
                        $reminderArray['date'] = date('d/m/Y', $dateTime['value']);
                        $reminderArray['time'] = date('h:i:s', $dateTime['value']);
                        $reminderArray['content'] = $content['value'];
                        $reminderArray['id'] = $enquiry->id;
                        
                    }
                    if(count($reminderArray) > 0){
                        leadSetReminder($reminderArray);
                    }
                    if(!empty($row1['notes'])){
                        $commentArray['content'] = $row1['notes'];
                        $commentArray['id'] = $enquiry->id;
                        $commentArray['type'] = 1;
                        storeLeadComment($reminderArray);
                    }
                }
            }
        

        $this->info('Successfully added.');
    }
}
