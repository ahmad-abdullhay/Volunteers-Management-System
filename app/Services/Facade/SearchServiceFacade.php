<?php
namespace App\Services\Facade;

use Illuminate\Support\Facades\Facade;

class SearchServiceFacade extends Facade
{

    /**
     * Returning service name
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'App\Services\Shared\SearchService';
    }
}
