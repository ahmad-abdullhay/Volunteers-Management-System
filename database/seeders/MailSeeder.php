<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Message\Mail;
use App\Models\Message\MailCategory;
use App\Models\Message\MailUser;
use App\Models\Notification;
use Illuminate\Database\Seeder;

class MailSeeder extends  Seeder
{
public function run ()
{
    MailCategory::create([
        "name"=> "البريد العام",
        "description"=>" ",
    ]);

    Mail::create([
        "title"=> "تذكير بالفعالية",
        "text"=> 'هذه الرسالة للتذكير بالفعالية يرجى القدوم على الوقت وعدم التأخر'  ."\n".
            'تم تحديد موعد الفعالية في اليوم الخامس من شهر ايار في الساعة الخامسة مساءً' ."\n".
        'يرجى عدم التأخر واحضار بطاقة التطوع وابرازها عند الدخول',
        "mail_category_id"=>1,
    ]);
    MailUser::create ([
        "is_read" => 0,
        "user_id" =>1,
        "mail_id" => 1,
    ]);
    MailUser::create ([
        "is_read" => 0,
        "user_id" =>2,
        "mail_id" => 1,
    ]);
    MailUser::create ([
        "is_read" => 0,
        "user_id" =>3,
        "mail_id" => 1,
    ]);
    Mail::create([
        "title"=> "ترحيب بالمتطوعين",
        "text"=> 'تتقدم الجمعية بالترحيب بالمتطوعين الجدد'  . "\n".
            'وتتمنى الخير والسعادة لجميع المتطوعين' ,

        "mail_category_id"=>1,
    ]);
    MailUser::create ([
        "is_read" => 0,
        "user_id" =>1,
        "mail_id" => 2,
    ]);
    MailUser::create ([
        "is_read" => 0,
        "user_id" =>2,
        "mail_id" => 2,
    ]);
    MailUser::create ([
        "is_read" => 0,
        "user_id" =>3,
        "mail_id" => 2,
    ]);
    Mail::create([
        "title"=> "تجديد البيانات",
        "text"=> 'يرجى الذهاب الى مقر المنظمة للقيام بعملية تجديد للبيانات'  ."\n".
            'يجب احضار بطاقة الهوية الشخصية والقدوم الى المركز قبل الساعة 4 مساءً'."\n".
        'في مدة اقصاها 5 ايام',

        "mail_category_id"=>1,
    ]);
    MailUser::create ([
        "is_read" => 0,
        "user_id" =>1,
        "mail_id" => 3,
    ]);
    MailUser::create ([
        "is_read" => 0,
        "user_id" =>2,
        "mail_id" => 3,
    ]);
    MailUser::create ([
        "is_read" => 0,
        "user_id" =>3,
        "mail_id" => 3,
    ]);
    Notification::create ([
        "content"=>"لقد تم الانتهاء من فعالية المدرسة",
        "user_id" => 1,
        "is_read" => 1
    ]);
    Notification::create ([
        "content"=>"لقد ربحت شارة جديدة",
        "user_id" => 1,
        "is_read" => 1
    ]);
    Notification::create ([
        "content"=>"لقد تم اضافة فعالية جديدة",
        "user_id" => 1,
        "is_read" => 0
    ]);
    Notification::create ([
        "content"=>"لقد ربحت 10 نقاط",
        "user_id" => 1,
        "is_read" => 0
    ]);
    Notification::create ([
        "content"=>"تم الغاء فعالية توزيع الطعام",
        "user_id" => 1,
        "is_read" => 0
    ]);
    Notification::create ([
        "content"=>"لقد ربحت شارة جديدة",
        "user_id" => 1,
        "is_read" => 0
    ]);
//    Category::create([
//        "name"=> "تعليمية",
//        "description"=>" ",
//    ]);
}
}
