<?php

use Illuminate\Database\Seeder;

class FileDeleteSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table("file_delete_setting")->insert(["id"=>1,"days"=>15,"clean_files_limits"=>5,"created_at"=>now(),"updated_at"=>now()]);
    }
}
