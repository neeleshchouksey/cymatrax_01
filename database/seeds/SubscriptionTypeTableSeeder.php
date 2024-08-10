<?php

use Illuminate\Database\Seeder;

class SubScriptionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $value = [
            [
                "id" => 1,
                "name" => 'Community',
                "charges" => 'Free',
                "no_of_clean_file" => 5,
                "plan_id" => '0',
                "text_1" => '5 audio files cleaned free monthly',
                "text_2" => 'Charge of $1.00/minute of each cleaned audio file',
                "text_3" => 'Unlimited downloads',
            ],
            [
                "id" => 2,
                "name" => 'Gold',
                "charges" => 12,
                "no_of_clean_file" => 150,
                "plan_id" => 'P-8T7484760V009323KMQ3KM',
                "text_1" => '50 audio files cleaned free monthly',
                "text_2" => 'Charge of $.50/minute of each cleaned audio file',
                "text_3" => 'Unlimited downloads',
            ],
            [
                "id" => 3,
                "name" => 'Platinum',
                "charges" => 45,
                "no_of_clean_file" => "Unlimited",
                "plan_id" => 'P-8T7484760V009323KM',
                "text_1" => 'Unlimited audio files cleaned free monthly',
                "text_2" => 'Charge of $1.00/minute of each cleaned audio file',
                "text_3" => null
            ]
        ];
        DB::table('subscription_type')->truncate();
        DB::table('subscription_type')->insert($value);

    }
}
