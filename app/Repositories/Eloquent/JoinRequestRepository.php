<?php

namespace App\Repositories\Eloquent;

use App\Models\JoinRequest;
use App\Repositories\JoinRequestRepositoryInterface;

class JoinRequestRepository extends BaseRepository implements JoinRequestRepositoryInterface
{
    /**
     * BaseRepository constructor.
     *
     * @param JoinRequest $model
     */
    public function __construct(JoinRequest $model)
    {
        parent::__construct($model);
    }

    public function changeRequestStatus($modelId, $status)
    {
        $joinRequest = $this->findById($modelId);
        $joinRequest->status = $status;
        $joinRequest->save();
    }

}
