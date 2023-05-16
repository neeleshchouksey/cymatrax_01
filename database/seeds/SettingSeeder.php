<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
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
                "user_id"=>1,
                "key"=>'time_on_disk',
                "value"=>15,
            ]
        );
    }
}
