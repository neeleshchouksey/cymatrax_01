<?php

use Illuminate\Database\Seeder;

class subscriptionType extends Seeder
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
                "id"=>1,
                "name"=>'Gold',
                "charges"=>8.99,
                "no_of_clean_file"=>50

            ],
            [
                "id"=>2,
                "name"=>'Platinum',
                "charges"=>14.99,
                "no_of_clean_file"=>150
                
            ],
            [
                "id"=>3,
                "name"=>'Unlimited',
                "charges"=>99.99,
                "no_of_clean_file"=>"Unlimited"
                
            ]
            ];

        DB::table('subscription_type')->insert($value);

        
    }
}
