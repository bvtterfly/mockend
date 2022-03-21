<?php

namespace App\Support\Mockend;

use App\Support\Mockend\Facades\Config;
use App\Support\Mockend\Fields\AutoIncrementField;
use App\Support\Mockend\Fields\SequenceGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Mockend
{
    public function __construct(private Collection $models, private Collection $routes)
    {
    }

    private function resetState()
    {
        $this->models = collect();
        $this->routes = collect();
    }

    public function init()
    {
        $this->resetState();
        $config = Config::get();
        $config
            ->each(function (array $modelConfig, string $model) {
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

                $this->addModel($model, new Model($model, $fields));

                if ($fields->whereInstanceOf(AutoIncrementField::class)->count()) {
                    app(SequenceGenerator::class)->init($model);
                }

                if (! $meta->crud) {
                    return;
                }

                $route = $meta->getRoute();

                $this->addRoute($route, new ModelRoute(
                    $model,
                    $meta
                ));
            });
    }

    public function hasModel($name): bool
    {
        return $this->models->has($name);
    }

    public function addModel($name, Model $model)
    {
        $this->models->put($name, $model);
    }

    public function getModel($name): ?Model
    {
        if (! $this->hasModel($name)) {
            return null;
        }

        return $this->models[$name];
    }

    public function getRoutes(): Collection
    {
        return $this->routes;
    }

    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addRoute($name, ModelRoute $route)
    {
        $this->routes->put($name, $route);
    }
}
