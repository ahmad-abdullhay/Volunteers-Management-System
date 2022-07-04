<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudController;
use App\Http\Requests\QuestionnaireRequest;
use App\Http\Requests\RoleRequest;
use App\Models\Questionnaire;
use App\Services\QuestionnaireService;
use App\Services\RoleService;
use Illuminate\Http\Request;

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
        return $this->handleSharedMessage($this->service->getAllForUser());
    }
    public function fillQuestionnaire (Questionnaire $questionnaire,Request $request)
    {
        return $this->handleSharedMessage($this->service->questionnaireFilling($questionnaire,$request->post()));
    }
}
