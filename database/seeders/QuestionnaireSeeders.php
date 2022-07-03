<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\QuestionnaireUser;
use Illuminate\Database\Seeder;

class QuestionnaireSeeders extends Seeder
{
public function run ()
{
    Questionnaire::create([
        "title"=>"تحليل التطوع",
        "description"=> "وصف طوييييييل جداً",
        "answersLimit"=> 7
    ]);
    Question::create([
        "question" =>"كيف حالك",
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
