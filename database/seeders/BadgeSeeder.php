<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Metric\BadgeCondition;
use App\Models\Metric\MetricQuery;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
public function run ()
{
    Badge::create ([
                "name"=>"المتواجد 50",
    "description"=> "وصول اجمالي ساعات التطوع ل50 ساعة"
    ]);
    MetricQuery::create ([
        "metric_id"=>1,
     "first_operation"=>"sum",
    "second_operation"=>"sum",
    "compare_operation"=>"more",
    "compare_value"=>50
    ]);
    BadgeCondition:: create ([
        "badge_id"=>1,
        "metrics_query_id"=>1,
    ]);


    Badge::create ([
        "name"=>"الملتزم",
        "description"=> "حضور كل الايام في فعالية واحدة"
    ]);
    MetricQuery::create ([
        "metric_id"=>2,
        "first_operation"=>"allTrue",
        "second_operation"=>"null",
        "compare_operation"=>"isTrue",
        "compare_value"=>0
    ]);
    BadgeCondition:: create ([
        "badge_id"=>2,
        "metrics_query_id"=>2,
    ]);


}
}
