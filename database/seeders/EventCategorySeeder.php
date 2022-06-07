<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
public function  run ()
{
    Category::create([
        "name"=> "خيرية",
        "description"=>" ",
    ]);
    Category::create([
        "name"=> "تعليمية",
        "description"=>" ",
    ]);
}
}
