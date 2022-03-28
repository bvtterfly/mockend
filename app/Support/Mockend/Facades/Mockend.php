<?php

namespace App\Support\Mockend\Facades;

use App\Support\Mockend\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void init()
 * @method static Collection getRoutes()
 * @method static Collection getModels()
 * @method static Model getModel(string $model)
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
