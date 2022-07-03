<?php

namespace Database\Seeders;

use App\Models\Message\MailCategory;
use App\Models\Metric\Leaderboard;
use App\Models\Metric\MetricQuery;
use Illuminate\Database\Seeder;

class LeaderboardSeeder extends Seeder
{
public function run ()
{

        MetricQuery::create ([
            "metric_id"=>1,
            "first_operation"=>"sum",
            "second_operation"=>"sum",
            "compare_operation"=>"null",
            "compare_value"=>-1
        ]);
    Leaderboard::create([
        "name"=> "ساعات التطوع",
        "description"=>"اكثر المتطوعين تحقيقاً لساعات تطوع مع الجمعية",
        "table_size" => 5,
        "metrics_query_id" => 12,
    ]);

    MetricQuery::create ([
        "metric_id"=>4,
        "first_operation"=>"sum",
        "second_operation"=>"trueCount",
        "compare_operation"=>"null",
        "compare_value"=>-1
    ]);
    Leaderboard::create([
        "name"=> "المشرفين",
        "description"=>"جدول لاكثر المتطوعين اشرافاً على فعاليات",
        "table_size" => 5,
        "metrics_query_id" => 13,
    ]);



}
}
