<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\RoleRequest;
use App\Models\EventUser;
use App\Models\Metric;
use App\Models\PreMetric;
use App\Repositories\Eloquent\MetricRepository;
use App\Services\MetricService;
use App\Services\RoleService;
use Illuminate\Database\Eloquent\Model;

class RoleController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param RoleService $service
     * @param RoleRequest $request
     */
    public function __construct(RoleService $service, RoleRequest $request)
    {
        // Call on parent constructor.
        parent::__construct($service, $request);
    }

    public function permissions()
    {
        return $this->handleSharedMessage($this->service->permissions());
    }
    public function test (){
     // $className = config('metric.'.$type);
       $model = app(ucfirst('App\Models\QuestionnaireUser'));

        if ($model->isWithEvent()) {
            dd("hoi");
        } else {
            dd("no");
        }
      $ss =new    MetricService(new MetricRepository(new Metric));
     return $ss->getAllPreDefinedMetric(15,5);

       //  $className = 'App\Models\EventUser'::class;
    }
}
