<?php

namespace Database\Seeders;

use App\Models\Metric;
use App\Models\User;
use Illuminate\Database\Seeder;

class MetricSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      //  Metric::factory(10)->create();
        Metric::create([
            "name"=>"ساعات التطوع",
    "description"=> "ساعات الحضور لكل متطوع",
    "type"=> 6
        ]);
        Metric::create([
            "name"=>"الحضور اليومي",
    "description"=> "حضور بيوم الفعالية",
    "type"=> 2
        ]);
              Metric::create([
                  "name"=>"اتمام الفعالية",
    "description"=> "التزم المتطوع لنهاية الفعالية",
    "type"=> 1
        ]);

    }
}
