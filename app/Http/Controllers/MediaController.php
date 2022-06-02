<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadMediaRequest;
use App\Services\Shared\MediaService;

class MediaController extends BaseController
{
    protected $service;
    public function __construct(MediaService $service)
    {
        $this->service = $service;
    }

    public function uploadMedia(UploadMediaRequest $request)
    {
        return $this->handleSharedMessage($this->service->uploadMedia($request->file('files')));
    }

    public function deleteMedia($id)
    {
        return $this->handleSharedMessage($this->service->deleteMedia($id));
    }

}
