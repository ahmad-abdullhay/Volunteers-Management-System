<?php

namespace App\Services\Shared;

use App\Common\SharedMessage;
use App\Repositories\Eloquent\MediaRepository;

class MediaService
{
    protected $repository;
    public function __construct(MediaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function uploadMedia($payload)
    {
        return new SharedMessage(__('success.store_successful'),
            $this->repository->uploadMedia($payload),
            true,
            null,
            200
        );
    }

    public function deleteMedia($id)
    {
        return new SharedMessage(__('success.store_successful'),
            $this->repository->deleteMedia($id),
            true,
            null,
            200
        );
    }

    public function uploadMediaFromUrl($urls)
    {
        return new SharedMessage(__('success.store_successful'),
            $this->repository->uploadMediaFromUrl($urls),
            true,
            null,
            200
        );
    }
}
