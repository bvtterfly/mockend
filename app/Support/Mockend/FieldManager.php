<?php

namespace App\Support\Mockend;

use App\Support\Mockend\Fields\AutoIncrementField;
use App\Support\Mockend\Fields\BelongsToField;
use App\Support\Mockend\Fields\FakerField;
use App\Support\Mockend\Fields\Field;
use App\Support\Mockend\Fields\HasManyField;
use App\Support\Mockend\Fields\HasOneField;
use App\Support\Mockend\Fields\NullField;
use App\Support\Mockend\Fields\RandomField;
use App\Support\Mockend\Fields\ValueField;
use Illuminate\Support\Arr;

class FieldManager
{
    public static function getField($model, $method, $args): Field
    {
        return match (true) {
            $method === 'id' => static::id($model),
            method_exists(static::class, $method) => static::{$method}($args),
            ! in_array($method, FakerField::SUPPORTED_METHODS) => new NullField(),
            default => new FakerField($method, $args)
        };
    }

    public static function value($args)
    {
        return new ValueField($args);
    }

    public static function id($args)
    {
        return new AutoIncrementField($args);
    }

    public static function random($args)
    {
        return new RandomField($args);
    }

    public static function belongsTo($args)
    {
        return new BelongsToField($args);
    }

    public static function hasMany($args)
    {
        return new HasManyField($args);
    }

    public static function hasOne($args)
    {
        return new HasOneField($args);
    }
}
