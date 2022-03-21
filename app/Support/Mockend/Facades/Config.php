<?php

namespace App\Support\Mockend\Facades;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Filesystem getDisk()
 * @method static string getConfigFilePath()
 * @method static Collection get()
 */
class Config extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Support\Mockend\Config::class;
    }
}
