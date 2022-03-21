<?php

namespace App\Support\Mockend;

use App\Support\Mockend\Facades\Mockend;
use Illuminate\Support\Facades\Route;

class RouteRegistrar
{
    public function registerRoutes()
    {
        Route::group(['middleware' => ['delay']], function () {
            Mockend::getRoutes()->each(function (ModelRoute $route, $key) {
                $model = Mockend::getModel($route->model);
                $meta = $route->meta;

                $factory = $model->getFactory();

                $this->addIndexRoute($key, $factory, $meta);
                $this->addShowRoute($key, $factory, $meta);
                $this->addStoreRoute($key, $factory, $meta);
                $this->addUpdateRoute($key, $factory, $meta);
                $this->addDestroyRoute($key, $factory, $meta);
            });
        });
    }

    /**
     * @param string $uri
     * @param  Factory  $factory
     * @param  Meta  $meta
     * @return void
     */
    protected function addIndexRoute(string $uri, Factory $factory, Meta $meta): void
    {
        Route::get($uri, function () use ($factory, $meta) {
            return $factory->create($meta->limit);
        })->name($meta->model.'.index');
    }

    /**
     * @param  string  $uri
     * @param  Factory  $factory
     * @param  Meta  $meta
     * @return void
     */
    protected function addShowRoute(string $uri, Factory $factory, Meta $meta): void
    {
        Route::get($uri.'/{id}', function () use ($factory) {
            return $factory->create();
        })->name($meta->model.'.show');
    }

    /**
     * @param  string  $uri
     * @param  Factory  $factory
     * @param  Meta  $meta
     * @return void
     */
    protected function addStoreRoute(string $uri, Factory $factory, Meta $meta): void
    {
        Route::post($uri, function () use ($factory) {
            return $factory->create();
        })->name($meta->model.'.store');
    }

    /**
     * @param  string  $uri
     * @param  Factory  $factory
     * @param  Meta  $meta
     * @return void
     */
    protected function addUpdateRoute(string $uri, Factory $factory, Meta $meta): void
    {
        Route::put($uri.'/{id}', function () use ($factory) {
            return $factory->create();
        })->name($meta->model.'.update');
    }

    /**
     * @param  string  $uri
     * @param  Factory  $factory
     * @param  Meta  $meta
     * @return void
     */
    protected function addDestroyRoute(string $uri, Factory $factory, Meta $meta): void
    {
        Route::delete($uri.'/{id}', function () {
            return [];
        })->name($meta->model.'.delete');
    }
}
