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
        Metric::create([
            "name"=>"مشرف على فعالية",
            "description"=> "مشاركة المتطوع بدور مشرف",
            "type"=> 1,
            "class" => "App\Models\EventUser"
        ]);

        Metric::create([
            "name"=>"التفاعل",
            "description"=> "تقييم مدى تفاعل المتطوع مع المتطوعين الاخرين",
            "type"=> 7,
        ]);
        $this->addRateEnums(5);

        Metric::create([
            "name"=>"التقبل",
            "description"=> "تقييم مدى تقبل المتطوع للافكار والاوامر",
            "type"=> 7,
        ]);
        $this->addRateEnums(6);

        Metric::create([
            "name"=>"وصف الشخصية",
            "description"=> "الوصف الاقرب لشخصية المتطوع في الفعالية",
            "type"=> 7,
        ]);
        Metric\MetricEnum::create([
            "enum_value" => "المهندس",
            "metric_id"=>7
        ]);
        Metric\MetricEnum::create([
            "enum_value" => "المسالم",
            "metric_id"=>7
        ]);
        Metric\MetricEnum::create([
            "enum_value" => "العادي",
            "metric_id"=>7
        ]);
        Metric\MetricEnum::create([
            "enum_value" => "المشاكس",
            "metric_id"=>7
        ]);
        Metric\MetricEnum::create([
            "enum_value" => "المحبوب",
            "metric_id"=>7
        ]);
        Metric::create([
            "name"=>"اتمام استبيان",
            "description"=> "ملء المتطوع لاستبيان من الجمعية",
            "type"=> 1,
            "class" => "App\Models\QuestionnaireUser"
        ]);
    }
    public function addRateEnums ($metric_id)
    {
        Metric\MetricEnum::create([
            "enum_value" => "ضعيف",
            "metric_id"=>$metric_id
        ]);
        Metric\MetricEnum::create([
            "enum_value" => "مقبول",
            "metric_id"=>$metric_id
        ]);
        Metric\MetricEnum::create([
            "enum_value" => "جيد",
            "metric_id"=>$metric_id
        ]);
        Metric\MetricEnum::create([
            "enum_value" => "جيد جدا",
            "metric_id"=>$metric_id
        ]);
        Metric\MetricEnum::create([
            "enum_value" => "ممتاز",
            "metric_id"=>$metric_id
        ]);
    }
}
