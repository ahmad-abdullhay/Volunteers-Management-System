<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelsSeeder extends  Seeder
{
public function run ()
    {
        Level::create ([
            "level" => 1,
            "level_name" => 'المستوى الاول',
            "start_points" => 0,
            "min_points" => 100,
        ]);
        Level::create ([
            "level" => 2,
            "level_name" => 'المستوى الثاني',
            "start_points" => 100,
            "min_points" => 200,
        ]);
        Level::create ([
            "level" => 3,
            "level_name" => 'المستوى الثالث',
            "start_points" => 200,
            "min_points" => 300,
        ]);
    }
}
