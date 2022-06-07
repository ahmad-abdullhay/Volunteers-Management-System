<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
public function run ()
{
    Post::create([
        "title" => "اهلا وسهلا",
                "admin_id" => 1,
                "text" => "ترحب جمعة التميز بجميع المتطوعين الجدد",
                "status" => "1"
    ]);
      Post::create([
          "title" => "مرحبا بالجميع",
		"admin_id" => 1,
		"text" => "ترحب جمعية التميز بالجميع",
		"status" => "1"
    ]);
        Post::create([
            "title" => "لنكثر من فعل الخير",
		"admin_id" => 1,
		"text" => "تمت اضافة فعاليات جديدة يرجى الاطلاع عليهم",
		"status" => "1"
    ]);
          Post::create([
              "title" => "لنسمو باخلاقنا",
		"admin_id" => 1,
		"text" => "يرجى المحافظة على الاخلاق العامة",
		"status" => "1"
    ]);
}
}
