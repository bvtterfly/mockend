<?php

namespace App\Support\Mockend\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static init()
 * @method static getRoutes()
 * @method static getModel(string $model)
 */
class Mockend extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Support\Mockend\Mockend::class;
    }
}
