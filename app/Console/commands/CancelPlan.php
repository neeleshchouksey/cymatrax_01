<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\UserSubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CancelPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:cancel_plan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage cancelled plan';

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
        $users = User::where(['is_cancelled' => 1, 'subscription' => 1])->get();
        if (!empty($users) && count($users)) {
            foreach ($users as $key => $user) {
                if ($user->plan_start_date) {
                    $now = Carbon::now();
                    $current_date = $now->format('d');
                    $date = Carbon::createFromFormat('Y-m-d', $user->plan_start_date)->format('d');
                    if ($current_date == $date) {
                        $update_user = User::where('id', $user->id)->update([
                            'subscription' => 0,
                            'plan_id' => null,
                            'plan_name' => null,
                            'charges' => null,
                            'no_of_clean_file' => null,
                            'subscription_id' => null,
                            'is_cancelled' => 0,
                            'plan_start_date' => null,
                            'plan_end_date' => null
                        ]);
                    }
                }
            }
        }
    }
}
