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
                "name"=>"المتواجد",
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

    Badge::create ([
        "name"=>"المشرف الخبير",
        "description"=> "المشاركة في 5 فعاليات كمشرف على الفعالية"
    ]);
    MetricQuery::create ([
        "metric_id"=>4,
        "first_operation"=>"trueCount",
        "second_operation"=>"null",
        "compare_operation"=>"more",
        "compare_value"=>4
    ]);
    BadgeCondition:: create ([
        "badge_id"=>3,
        "metrics_query_id"=>3,
    ]);

    Badge::create ([
        "name"=>"المسالم",
        "description"=> "الحصول على تقييم المسالم من مشرف الفعالية"
    ]);
    MetricQuery::create ([
        "metric_id"=>7,
        "first_operation"=>"null",
        "second_operation"=>"null",
        "compare_operation"=>"equal",
        "compare_value"=>1
    ]);
    BadgeCondition:: create ([
        "badge_id"=>4,
        "metrics_query_id"=>4,
    ]);

    Badge::create ([
        "name"=>"الاستراتيجي",
        "description"=> "الحصول على تقييم المهندس من مشرف الفعالية"
    ]);
    MetricQuery::create ([
        "metric_id"=>7,
        "first_operation"=>"null",
        "second_operation"=>"null",
        "compare_operation"=>"equal",
        "compare_value"=>0
    ]);
    BadgeCondition:: create ([
        "badge_id"=>5,
        "metrics_query_id"=>5,
    ]);
}
}
