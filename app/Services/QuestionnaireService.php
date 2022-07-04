<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Models\Metric\EventPointStats;
use App\Models\Metric\UserTotalPoints;
use App\Models\Questionnaire;
use App\Repositories\Eloquent\QuestionnaireRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Services\Shared\BaseService;
use Illuminate\Support\Facades\Auth;

class QuestionnaireService extends BaseService
{
    protected string $modelName = "Questionnaire";
    protected MetricService $metricService;
    public function __construct(QuestionnaireRepository $repository,MetricService $metricService)
    {
        $this->metricService = $metricService;
        parent::__construct($repository);
    }

    public function getAll(): SharedMessage
    {
        return new SharedMessage(__('success.list', ['model' => 'Permission']),
            $this->repository->getAll(),
            true,
            null,
            200
        );
    }
    public function getAllForUser(): SharedMessage
    {
        return new SharedMessage(__('success.list', ['model' => 'Permission']),
            $this->repository->getAllForUser(Auth::id()),
            true,
            null,
            200
        );
    }
    public function questionnaireFilling (Questionnaire $questionnaire,$payload)
    {
//                        $myfile = fopen("more.txt", "w") or die("Unable to open file!");
//                $myJSON=json_encode($payload);
//                fwrite($myfile, $myJSON);
//                fclose($myfile);
        $userId =Auth::id();
        $this->repository->userQuestionnaireFilling ($questionnaire->id,$userId);
       $result =  $this->metricService->onQuestionnaireFilling($questionnaire);





        return new SharedMessage(__('success.join-status-update'),
            ["pointStats"=>$this->getQuestionnaireEnds($result)],
            true,
            null,
            200
        );
     //   return ["done" => true];
    }
    public function getQuestionnaireEnds ($result)
    {
        $userId = Auth::id();
        $totalPoints = UserTotalPoints::where('user_id', $userId)->first();
        $stats = new EventPointStats;
        $stats->points_before = $totalPoints->total_points - 10;
        //$totalPoints -$result->points;
        $stats->points_added =  10;
        //$result->points;
        return $stats;
    }

}
