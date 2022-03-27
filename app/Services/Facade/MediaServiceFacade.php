<?php
namespace App\Services\Facade;

use Illuminate\Support\Facades\Facade;

class MediaServiceFacade extends Facade
{

    /**
     * Returning service name
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Services\Shared\MediaService';
    }
}
