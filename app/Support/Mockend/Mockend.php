<?php

namespace App\Support\Mockend;

use App\Exceptions\InvalidConfiguration;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

final class Mockend
{
    private static array $models = [];

    private static array $routes = [];

    public static function init()
    {
        try {
            $config = json_decode(Storage::disk('base')->get('.mockend.json'), true, flags: JSON_THROW_ON_ERROR);
        } catch (\Exception $e) {
            throw InvalidConfiguration::config();
        }
        collect(array_keys($config))
            ->each(function ($model) use ($config) {
                $modelConfig = $config[$model];
                $metaArr = Arr::get($modelConfig, '_meta', []);
                $metaArr = array_merge(
                    Meta::getDefaultValue(),
                    $metaArr
                );
                $meta = Meta::fromArray($model, $metaArr);
                $fields = collect(Arr::except($modelConfig, ['_meta']))
                    ->mapWithKeys(function ($fieldOption, $fieldName) use ($model) {
                        if (is_string($fieldOption)) {
                            return [$fieldName => FieldManager::getField($model, $fieldOption, [])];
                        }
                        $method = array_keys($fieldOption)[0];
                        $args = $fieldOption[$method];

                        return [$fieldName => FieldManager::getField($model, $method, $args)];
                    });

                self::addModel($model, new Model($model, $fields));

                if (! $meta->crud) {
                    return;
                }

                $route = $meta->getRoute();

                self::addRoute($route, new ModelRoute(
                    $model,
                    $meta
                ));
            });
    }

    public static function hasModel($name): bool
    {
        return Arr::has(self::$models, $name);
    }

    public static function addModel($name, Model $model)
    {
        self::$models[$name] = $model;
    }

    public static function getModel($name): ?Model
    {
        if (! self::hasModel($name)) {
            return null;
        }

        return self::$models[$name];
    }

    public static function getRoutes(): Collection
    {
        return collect(self::$routes);
    }

    public static function getModels(): Collection
    {
        return collect(self::$models);
    }

    public static function addRoute($name, ModelRoute $route)
    {
        self::$routes[$name] = $route;
    }
}
