<?php

namespace App\Services;

use App\Common\SharedMessage;
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
    public function questionnaireFilling (Questionnaire $questionnaire)
    {
        $userId =Auth::id();
        $this->repository->userQuestionnaireFilling ($questionnaire->id,$userId);
        $this->metricService->onQuestionnaireFilling($questionnaire);
        return new SharedMessage(__('success.join-status-update'),
            ["done" => true],
            true,
            null,
            200
        );
     //   return ["done" => true];
    }
}
