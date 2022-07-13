<?php

namespace App\Services;

use App\Models\Traits;
use App\Repositories\Eloquent\InventoryRepository;
use App\Repositories\Eloquent\TraitsRepository;
use App\Services\Shared\BaseService;

class TraitsService extends BaseService
{
    public function __construct(TraitsRepository $repository)
    {
        parent::__construct($repository);
    }
    public function assignTraitToUser (Traits $traits,int $value,int $userId)
    {
        $this->repository->assignTraitToUser ($traits, $value, $userId);
    }

}
