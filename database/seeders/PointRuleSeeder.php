<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Metric\MetricQuery;
use App\Models\Metric\PointRule;
use Illuminate\Database\Seeder;

class PointRuleSeeder extends Seeder
{
public function run ()
{
    MetricQuery::create ([
        "metric_id"=>2,
        "first_operation"=>"sum",
        "second_operation"=>"null",
        "compare_operation"=>"null",
        "compare_value"=>-1
    ]);
    PointRule::create ([
        "rule_name"=>"نقاط الحضور",
        "description"=> "نقطتين لكل يوم حضور",
        "points" => 2,
        "metrics_query_id" => 3
    ]);

    MetricQuery::create ([
        "metric_id"=>1,
        "first_operation"=>"sum",
        "second_operation"=>"null",
        "compare_operation"=>"null",
        "compare_value"=>-1
    ]);
    PointRule::create ([
        "rule_name"=>"نقاط ساعات التطوع",
        "description"=> "نقطة لكل ساعة حضور",
        "points" => 1,
        "metrics_query_id" => 4
    ]);
    MetricQuery::create ([
        "metric_id"=>3,
        "first_operation"=>"sum",
        "second_operation"=>"null",
        "compare_operation"=>"null",
        "compare_value"=>-1
    ]);
    PointRule::create ([
        "rule_name"=>"اتمام الفعالية",
        "description"=> "10 نقاط عند اتمام الفعالية",
        "points" => 10,
        "metrics_query_id" => 5
    ]);




}
}
