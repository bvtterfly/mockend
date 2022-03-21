<?php

namespace App\Support\Mockend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static registerRoutes()
 */
class RouteRegistrar extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Support\Mockend\RouteRegistrar::class;
    }
}
