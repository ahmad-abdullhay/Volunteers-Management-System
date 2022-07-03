<?php

namespace App\Repositories\Eloquent;

use App\Models\Metric\PointRule;
use App\Models\Metric\UserPoint;
use App\Models\Questionnaire;
use App\Models\QuestionnaireUser;

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
}
