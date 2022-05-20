<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;

class CategoryController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param CategoryService $service
     * @param CategoryRequest $request
     */
    public function __construct(CategoryService $service, CategoryRequest $request)
    {

        // Call on parent constructor.
        parent::__construct($service, $request);
    }
}
