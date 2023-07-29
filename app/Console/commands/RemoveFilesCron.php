<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class RemoveFilesCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $file = public_path('upload/1680544308_file_example_MP3_1MG.mp3');

        if (File::exists($file)) {
            File::delete($file);
        }

        $file_days = DB::table('file_delete_setting')->first(['days']);
        if(!empty($file_days)) {
            $remove = DB::table('uploads')->Where('created_at', '<', Carbon::now()->subDays($file_days->days))->get(['id','file_name']);
            foreach($remove as $val){
                Log::channel('deleted_file_info')->info($val->file_name.' file is permanently deleted');
                $delete = "upload/".$val->file_name;
                $delete = public_path("upload/".$val->file_name);
                if (File::exists($delete)) {
                    File::delete($delete);
                }
                DB::table('uploads')->where('id', $val->id)->delete();
            }
        }
    }
}
