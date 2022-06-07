<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventMetric;
use App\Models\EventUser;
use App\Models\Metric\EventMetricConfiguration;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {

        $usersData = [];
        $users = [1];
        foreach ($users as $key => $user){
            $usersData[$user] = [
                'status' => 1,
                'is_supervisor' => 1
            ];
        }
        Event::create([
            "name" => "فعالية جمع القمامة",
            "description" => "هدف الفعالية تصميم براشورات تعرف عن الجمعية \n ثم طباعة هذه البشورات وتوزيعها في المدينة \n ستمتد هذه الفعالية لمدة اسبوع واحد \n ووقت التطوع ساعتان يومياً",
            "start_date" => "2022-06-12",
            "required_volunteers_number" => 10,
            "end_date" => "2022-06-16",
        ])->users()->attach($usersData);

        EventMetric::create([
            "event_id" => 1,
            "metric_id" => 1,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 1,
            "metric_id" => 1,
            "values_limit" => 10,
            "min_value" => 1,
            "max_value" => 5,
        ]);
        EventMetric::create([
            "event_id" => 1,
            "metric_id" => 2,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 1,
            "metric_id" => 2,
            "values_limit" => 10,
        ]);
        EventMetric::create([
            "event_id" => 1,
            "metric_id" => 3,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 1,
            "metric_id" => 3,
            "at_event_end" => 1,
        ]);
        EventMetric::create([
            "event_id" => 1,
            "metric_id" => 4,
        ]);
        EventCategory::create([
            "event_id" => 1,
            "category_id" => 1,
        ]);
        Event::create([
            "name" => "فعالية توزيع الملابس",
            "description" => "هدف الفعالية فرز الملابس المتبرع بها الى اقسام \n ثم احصائها ووضع اولوية لتوزيعها على المحتاجين \n ستمتد الفعالية اسبوع واحد بشكل يومي \n ووقت التطوع ثلاث ساعات يومياً",
            "start_date" => "2022-06-12",
            "required_volunteers_number" => 22,
            "end_date" => "2022-06-16",

        ])->users()->attach($usersData);
        EventMetric::create([
            "event_id" => 2,
            "metric_id" => 1,
        ]);
        EventMetric::create([
            "event_id" => 2,
            "metric_id" => 2,
        ]);
        EventMetric::create([
            "event_id" => 2,
            "metric_id" => 3,
        ]);
        EventCategory::create([
            "event_id" => 2,
            "category_id" => 1,
        ]);
        Event::create([
            "name" => "فعالية التعريف في الجمعية",
            "description" => "هدف الفعالية هو تعريف اهالي الحي \n بنشاطات واهداف الجمعية \n عن طريق تصميم بروشورات وتوزيعها",
            "start_date" => "2022-06-12",
            "required_volunteers_number" => 20,
            "end_date" => "2022-06-16",
            "status" => 1

        ])->users()->attach($usersData);
        EventUser::create([
            'event_id' => 3,
            'user_id' => 2,
            'status' => 1,
            'is_supervisor' => 0
        ]);
        EventUser::create([
            'event_id' => 3,
            'user_id' => 3,
            'status' => 1,
            'is_supervisor' => 0
        ]);

        EventMetric::create([
            "event_id" => 3,
            "metric_id" => 1,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 3,
            "metric_id" => 1,
            "values_limit" => 10,
            "min_value" => 1,
            "max_value" => 5,
        ]);
        EventMetric::create([
            "event_id" =>3,
            "metric_id" => 2,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 3,
            "metric_id" => 2,
            "values_limit" => 10,
        ]);
        EventMetric::create([
            "event_id" => 3,
            "metric_id" => 3,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 3,
            "metric_id" => 3,
            "at_event_end" => 1,
        ]);
        EventMetric::create([
            "event_id" => 3,
            "metric_id" => 4,
        ]);
        EventCategory::create([
            "event_id" => 3,
            "category_id" => 2,
        ]);

        EventMetric::create([
            "event_id" => 3,
            "metric_id" => 5,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 3,
            "metric_id" => 5,
            "at_event_end" => 1,
        ]);
        EventMetric::create([
            "event_id" =>3,
            "metric_id" => 6,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 3,
            "metric_id" => 6,
            "at_event_end" => 1,
        ]);
        EventMetric::create([
            "event_id" => 3,
            "metric_id" => 7,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 3,
            "metric_id" => 7,
            "at_event_end" => 1,
        ]);
        Event::create([
            "name" => "فعالية التعريف بالاختصاصات",
            "description" => "هدف الفعالية هو تعريف طلاب المدارس \n بالاختصاصات الجامعية المختلفة \n عن طريق الذهاب الى المدارس وشرح الاختصاصات للطلاب",
            "start_date" => "2022-06-12",
            "required_volunteers_number" => 15,
            "end_date" => "2022-06-16",
            "status" => 1

        ])->users()->attach($usersData);
        EventUser::create([
            'event_id' => 4,
            'user_id' => 2,
            'status' => 1,
            'is_supervisor' => 0
        ]);
        EventUser::create([
            'event_id' => 4,
            'user_id' => 3,
            'status' => 1,
            'is_supervisor' => 0
        ]);

        EventMetric::create([
            "event_id" => 4,
            "metric_id" => 1,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 4,
            "metric_id" => 1,
            "values_limit" => 7,
            "min_value" => 1,
            "max_value" => 3,
        ]);
        EventMetric::create([
            "event_id" => 4,
            "metric_id" => 2,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 4,
            "metric_id" => 2,
            "values_limit" => 7,
        ]);
        EventMetric::create([
            "event_id" => 4,
            "metric_id" => 3,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 4,
            "metric_id" => 3,
            "at_event_end" => 1,
        ]);
        EventMetric::create([
            "event_id" => 4,
            "metric_id" => 4,
        ]);
        EventMetric::create([
            "event_id" => 4,
            "metric_id" => 5,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 4,
            "metric_id" => 5,
            "at_event_end" => 1,
        ]);
        EventMetric::create([
            "event_id" => 4,
            "metric_id" => 6,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 4,
            "metric_id" => 6,
            "at_event_end" => 1,
        ]);
        EventMetric::create([
            "event_id" => 4,
            "metric_id" => 7,
        ]);
        EventMetricConfiguration::create([
            "event_id" => 4,
            "metric_id" => 7,
            "at_event_end" => 1,
        ]);
        EventCategory::create([
            "event_id" => 4,
            "category_id" => 2,
        ]);
        $usersData = [];
        $users = [2];
        foreach ($users as $key => $user){
            $usersData[$user] = [
                'status' => 1,
                'is_supervisor' => 1
            ];
        }
        Event::create([
            "name" => "فعالية الفلكي الصغير",
            "description" => "هدف الفعالية هو زيارة المدارس الابتدائية \n والقيام باعطاء حصص للطلاب عن علم الفلك \n وتوزيع هداية رمزية على الاطفال المشاركين",
            "start_date" => "2022-06-12",
            "required_volunteers_number" => 25,
            "end_date" => "2022-06-16",
            "status" => 0

        ])->users()->attach($usersData);;

        EventUser::create([
            'event_id' => 5,
            'user_id' => 3,
            'status' => 1,
            'is_supervisor' => 0
        ]);
        EventMetric::create([
            "event_id" => 5,
            "metric_id" => 1,
        ]);
        EventMetric::create([
            "event_id" => 5,
            "metric_id" => 2,
        ]);
        EventMetric::create([
            "event_id" => 5,
            "metric_id" => 3,
        ]);
        EventCategory::create([
            "event_id" => 5,
            "category_id" => 1,
        ]);
    }
}
