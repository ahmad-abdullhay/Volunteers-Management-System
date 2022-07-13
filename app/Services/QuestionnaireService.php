<?php

namespace App\Services;

use App\Common\SharedMessage;
use App\Http\Requests\QuestionnaireRequest;
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
    protected InventoryService $inventoryService;
    public function __construct(QuestionnaireRepository $repository,MetricService $metricService,InventoryService $inventoryService)
    {
        $this->metricService = $metricService;
        $this->inventoryService = $inventoryService;
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

    public function getUserWithFilter(Questionnaire $questionnaire,int $status): SharedMessage
    {
        if ($status == 0){
            return new SharedMessage(__('success.list', ['model' => 'Permission']),
                $this->repository->doneUsers($questionnaire->id), true, null, 200
            );
        }
        if ($status == 1){
            return new SharedMessage(__('success.list', ['model' => 'Permission']),
                $this->repository->sentUsers($questionnaire->id), true, null, 200
            );
        }
        if ($status == 2){
            return new SharedMessage(__('success.list', ['model' => 'Permission']),
                $this->repository->notSentUsers($questionnaire->id), true, null, 200
            );
        }
        return new SharedMessage(__('success.list', ['model' => 'Permission']),
            [], true, null, 200
        );
    }
    public function sendQuestionnaire (Questionnaire $questionnaire)
    {
        return new SharedMessage(__('success.list', ['model' => 'Permission']),
            $this->repository->sendQuestionnaireToNotSentUsers($questionnaire->id), true, null, 200
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

        $this->inventoryService->setTraits($questionnaire->inventories,$payload);
//
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
        $stats->points_before = $totalPoints->total_points - $result;
        //$totalPoints -$result->points;
        $stats->points_added =  $result;
        //$result->points;
        return $stats;
    }

}
