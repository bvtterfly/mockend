<?php

namespace App\Exceptions;

use Exception;

final class InvalidConfiguration extends Exception
{
    public static function config()
    {
        return new static("Can't parse config file, it isn't valid json.");
    }

    public static function model($model)
    {
        return new static("Can't generate data, {$model} is missing.");
    }
}
