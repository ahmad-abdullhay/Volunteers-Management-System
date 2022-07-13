<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireUser;
use App\Models\Traits;
use Illuminate\Database\Seeder;

class QuestionnaireSeeders extends Seeder
{
public function run ()
{
    Inventory::create([
        "name"=>"دوافع التطوع",
        "description"=> "تحليل يصف كل سمة من سمات الشخصيات",
        "shortcut"=> "vfi",

    ]);
    Traits::create([
        "name"=>"القيمة",
        "description"=> "تحليل يصف كل سمة من سمات الشخصيات",
        "inventory_id" => 1
    ]);
    Traits::create([
        "name"=>"الفهم",
        "description"=> "تحليل يصف كل سمة من سمات الشخصيات",
        "inventory_id" => 1

    ]);
    Traits::create([
        "name"=>"التعزيز",
        "description"=> "تحليل يصف كل سمة من سمات الشخصيات",
        "inventory_id" => 1

    ]);
    Traits::create([
        "name"=>"المهنة",
        "description"=> "تحليل يصف كل سمة من سمات الشخصيات",
        "inventory_id" => 1

    ]);
    Traits::create([
        "name"=>"الاجتماعية",
        "description"=> "تحليل يصف كل سمة من سمات الشخصيات",
        "inventory_id" => 1

    ]);
    Traits::create([
        "name"=>"الوقاية",
        "description"=> "تحليل يصف كل سمة من سمات الشخصيات",
        "inventory_id" => 1

    ]);
    Questionnaire::create([
        "title"=>"تحليل دوافع التطوع",
        "description"=> "هذا الاستبيان سيساعد الجمعية على فهم دوافع المتطوعين بشكل اكبر",
        "answersLimit"=> 7,
        "inventory_id" => 1
    ]);
    Question::create([
        "question" =>"يمكن أن يساعدني التطوع في التقرب من مكان ما
حيث أود أن أعمل",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"اصدقائي متطوعين ايضاً",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"انا مهتم بالاقل حظاً مني",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"الاشخاص القريبين مني طلبو مني ان اتطوع",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع يجعلني اشعر اكثر بالاهمية",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"الاشخاص الذين اعرفهم مهتمون بخدمة المجتمع",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع ينسيني اوقاتي الصعبة",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"انا مهتم تحديداً بالفئة التي اساعدها",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع يجعلني اقل وحدةً",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"يمكنني ان اتعرف على اشخاص جديدة تساعدني بتحسين عملي الخاص",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع يخفف عني احساسي بعدم الاستحقاق عند رؤية الاقل حظاً",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"يمكنني ان اتعلم اكثر عن المغزى من عملي",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع يزيد من تقديري لذاتي",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع يجعلني ارى وجهات نظر جديدة للاشياء",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع يجعلني ارى خيارات جديدة للعمل",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"انا اشعر بالتعاطف اتجاه الاشخاص الاقل حظاً",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"القريبون مني يضعو قيمة عالية لخدمة المجتمع",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع يجعلني اتعلم من خلال المساهمة المباشرة بالعمل",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"انا اشعر انه من المهم مساعدة الاخرين",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع يساعدني بحل مشاكلي الشخصية",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"سيساعدني التطوع بالنجاح في مهنتي",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"يمكنني ان اعمل شيئاً للقضايا المهمة لي",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع نشاط مهم للاشخاص المقربين مني",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع مهرب جيد من متاعبي الخاصة",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"يساعدني التطوع بفهم الاختلاف بين الشخصيات",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"اشعر بحاجة الناس لي عندما اتطوع",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"اشعر بشعور افضل اتجاه نفسي عندما اتطوع",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"خبرات التطوع قسم مهم في سيرتي الذاتية",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"التطوع طريقة جيدة لاكتساب اصدقاء جدد",
        "questionnaire_id" =>1
    ]);
    Question::create([
        "question" =>"يساعدني التطوع بفهم نقاط قوتي",
        "questionnaire_id" =>1
    ]);
    QuestionnaireUser::create([
        "is_done"=>0,
        "user_id"=> 1,
        "questionnaire_id" =>1
    ]);
    QuestionnaireUser::create([
        "is_done"=>0,
        "user_id"=> 2,
        "questionnaire_id" =>1
    ]);
    Questionnaire::create([
        "title"=>"تحليل الشخصيات",
        "description"=> "وصف طوييييييل جداً",
        "answersLimit"=> 5
    ]);
    Question::create([
        "question" =>"اين ترى نفسك بعد سنة",
        "questionnaire_id" =>2
    ]);
    Question::create([
        "question" =>"اين ترى نفسك بعد سنتين",
        "questionnaire_id" =>2
    ]);
    QuestionnaireUser::create([
        "is_done"=>0,
        "user_id"=> 1,
        "questionnaire_id" =>2
    ]);
}
}
