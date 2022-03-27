<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

interface MediaRepositoryInterface extends RepositoryInterface
{
    public function uploadMedia($payload);

    public function deleteMedia($mediaId);

    public function uploadMediaFromUrl($urls);

}
