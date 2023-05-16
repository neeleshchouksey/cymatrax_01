<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("settings")->insert(
            [
                
                "key"=>'time_on_disk',
                "value"=>15,
            ],
            [
               
                "key"=>'file_limit_upload',
                "value"=>5,
            ]
        );
    }
}
