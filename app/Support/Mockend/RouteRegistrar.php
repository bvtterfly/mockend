<?php

namespace App\Support\Mockend;

use Illuminate\Support\Facades\Route;

class RouteRegistrar
{
    public static function registerRoutes()
    {
        Route::group(['middleware' => ['delay']], function () {
            Mockend::getRoutes()->each(function (ModelRoute $route, $key) {
                $model = Mockend::getModel($route->model);
                $meta = $route->meta;

                $factory = $model->getFactory();

                self::addIndexRoute($key, $factory, $meta);
                self::addShowRoute($key, $factory);
                self::addStoreRoute($key, $factory);
                self::addUpdateRoute($key, $factory);
                self::addDestroyRoute($key, $factory);
            });
        });
    }

    /**
     * @param string $uri
     * @param  Factory  $factory
     * @param  Meta  $meta
     * @return void
     */
    protected static function addIndexRoute(string $uri, Factory $factory, Meta $meta): void
    {
        Route::get($uri, function () use ($factory, $meta) {
            return $factory->create($meta->limit);
        });
    }

    /**
     * @param string $uri
     * @param  Factory  $factory
     * @return void
     */
    protected static function addShowRoute(string $uri, Factory $factory): void
    {
        Route::get($uri.'/{id}', function () use ($factory) {
            return $factory->create();
        });
    }

    /**
     * @param string $uri
     * @param  Factory  $factory
     * @return void
     */
    protected static function addStoreRoute(string $uri, Factory $factory): void
    {
        Route::post($uri, function () use ($factory) {
            return $factory->create();
        });
    }

    /**
     * @param string $uri
     * @param  Factory  $factory
     * @return void
     */
    protected static function addUpdateRoute(string $uri, Factory $factory): void
    {
        Route::put($uri.'/{id}', function () use ($factory) {
            return $factory->create();
        });
    }

    /**
     * @param string $uri
     * @param  Factory  $factory
     * @return void
     */
    protected static function addDestroyRoute(string $uri, Factory $factory): void
    {
        Route::delete($uri.'/{id}', function () {
            return [];
        });
    }
}
