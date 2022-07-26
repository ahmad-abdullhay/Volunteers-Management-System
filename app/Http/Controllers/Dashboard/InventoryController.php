<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\CrudController;
use App\Http\Requests\MainRequest;
use App\Models\Inventory;
use App\Services\InventoryService;
use Illuminate\Http\Request;


class InventoryController extends CrudController
{
    /**
     * Create a new instance form branch repository.
     * @constructor
     * @param InventoryService $service
     * @param MainRequest $request
     */
    public function __construct(InventoryService $service, MainRequest $request)
    {
        parent::__construct($service, $request);
    }

    public function getAll ()
    {
        return $this->handleSharedMessage($this->service->getAll());
    }
    public function getTraitsStats (Inventory $inventory)
    {
        return $this->service->getTraitsStats($inventory);
    }
}
