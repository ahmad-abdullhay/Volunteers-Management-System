<?php

namespace App\Repositories\Eloquent;

use App\Models\Metric\PointRule;
use App\Models\Metric\UserPoint;
use App\Models\Questionnaire;
use App\Models\QuestionnaireUser;
use App\Models\User;

class QuestionnaireRepository extends BaseRepository
{
    /**
     * BaseRepository constructor.
     *
     * @param Questionnaire $model
     */
    public function __construct(Questionnaire $model)
    {
        parent::__construct($model);
    }
    public function getAll ()
    {

      return  $this->model::get();
    }
    public function getAllForUser (int $userId)
    {
    return    $this->model->whereHas('questionnaireUsers', function ($query) use ($userId) {
            $query->where("user_id", $userId)->where("is_done",0);
        })->get();
    }

    public function userQuestionnaireFilling ($questionnaire_id,$user_Id)
    {
        $questionnaireUser =  QuestionnaireUser::where("questionnaire_id", $questionnaire_id)
            ->where("user_id", $user_Id)->where("is_done",0)->first();
        $questionnaireUser->is_done = 1;
        $questionnaireUser->save();

    }

    public function sentUsers ($questionnaireId)
    {
        return QuestionnaireUser::where ("is_done" , 0)->where("questionnaire_id",$questionnaireId)->with('users')-> get();
    }

    public function notSentUsers ($questionnaireId)
    {
        return User::whereNotIn('id',QuestionnaireUser::select("user_id")->where("questionnaire_id",$questionnaireId))->get();
    }

    public function doneUsers ($questionnaireId)
    {
        return QuestionnaireUser::where ("is_done" , 1)->where("questionnaire_id",$questionnaireId)->with('users')-> get();

    }
    public function sendQuestionnaireToNotSentUsers ($questionnaireId)
    {
        $users = $this->notSentUsers($questionnaireId);
        foreach ($users as $user)
        {
            $this->sendQuestionnaireToUser($user->id,$questionnaireId);
        }
        return ["count" => count($users)];
    }
    public function sendQuestionnaireToUser ($userId,$questionnaireId)
    {
        $questionnaireUser = new QuestionnaireUser;
        $questionnaireUser->user_id = $userId;
        $questionnaireUser->questionnaire_id = $questionnaireId;
        $questionnaireUser->is_done = 0;
        $questionnaireUser->save();
    }
}
