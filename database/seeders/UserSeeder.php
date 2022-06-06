<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name"=> "احمد عبد الحي",
            "email" => "ahmad@3km.com",
            "date_of_birth"=> "2022-04-19",
            "phone"=> "+963123123123",
            "gender"=> 1,
            "location"=> "Mazzeh gabal",
            "job" => "مصمم",
            "volunteering_history"=> "TESTING",
            "is_active" => 1
        ]);
        //User::factory(10)->create();
        User::create([
            "name"=> "حسان كريم الدين",
           "email" => "hassan2@3km.com",
             "date_of_birth"=> "2022-04-19",
             "phone"=> "+9639375801812",
                "gender"=> 1,
                "location"=> "Mazzeh gabal",
                "job" => "مهندس",
                "volunteering_history"=> "TESTING",
            "is_active" => 1
        ]);

        User::create([
            "name"=> "يزن شيخ الارض",
            "email" => "ahmad1@3km.com",
            "date_of_birth"=> "2022-04-19",
            "phone"=> "+963123456789",
            "gender"=> 1,
            "location"=> "Mazzeh gabal",
            "job" => "مدير",
            "volunteering_history"=> "TESTING",
            "is_active" => 1
        ]);
    }
}
