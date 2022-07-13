<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudController;
use App\Http\Requests\QuestionnaireRequest;
use App\Http\Requests\RoleRequest;
use App\Models\Questionnaire;
use App\Services\QuestionnaireService;
use App\Services\RoleService;

class QuestionnaireController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param QuestionnaireService $service
     * @param QuestionnaireRequest $request
     */
    public function __construct(QuestionnaireService $service, QuestionnaireRequest $request)
    {
        // Call on parent constructor.
        parent::__construct($service, $request);
    }

    public function getAll ()
    {
        return $this->handleSharedMessage($this->service->getAll());
    }

    public function getUsers (Questionnaire $questionnaire,QuestionnaireRequest $request)
    {
        return $this->handleSharedMessage($this->service->getUserWithFilter($questionnaire,$request->query()['status']));
    }
    public function sendQuestionnaire (Questionnaire $questionnaire)
    {
        return $this->handleSharedMessage($this->service->sendQuestionnaire($questionnaire));

    }
}
