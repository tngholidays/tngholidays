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

class FacebookLead extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lead:facebook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Facebook lead';

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
        $data = file_get_contents('https://crm.bigtos.com/home/uk');
        $data=json_decode($data);
        print_r($data);

        $this->info('Successfully sent daily reminder to everyone.');
    }
}
