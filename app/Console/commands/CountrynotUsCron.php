<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CountrynotUsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countrynotus:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Contry not US then two fields update';

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
        $userslist = DB::table('users')
        ->select('name','email')
        ->where('country', '<>', 'US')
        ->whereNull('last_login_at')
        ->whereNull('trial_expiry_date')
        ->whereNull('deleted_at')
        ->get()->toArray();

        $results = DB::table('users')
        ->where('country', '<>', 'US')
        ->whereNull('last_login_at')
        ->whereNull('trial_expiry_date')
        ->update(['deleted_at' => now()]);
        $mailToAddress = config('service.MAIL_FROM_ADDRESS.email_to');
        $from = config('service.MAIL_FROM_ADDRESS.email_from');
        $message = "Hello Friends How Are You ?";
        $to = $mailToAddress;
        $subject = 'User Status Update';
        //Log::channel('deleted_file_info')->info($userslist);
            // if(isset($userslist)){
            //     foreach($userslist as $key=>$value){ 
            //         $test = $value->name.'-->'.$value->email;
            //         Log::channel('deleted_file_info')->info($test);
            //     }
            // } 

        
           
        try {
            $mail = Mail::send('emails.usersUpdatedEmail', [
                "userslist" => $userslist
            ], function ($message) use ($to,$from, $subject) {
                $message->to($to);
                $message->from($from);
                $message->subject($subject);
            });
          
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
