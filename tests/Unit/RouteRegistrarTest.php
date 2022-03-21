<?php

namespace Tests\Unit;

use App\Support\Mockend\Facades\Mockend;
use App\Support\Mockend\Facades\RouteRegistrar;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class RouteRegistrarTest extends TestCase
{
    /** @test */
    public function it_can_register_routes()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode([
            'TestModel' => [
                'id' => 'id',
            ],
        ]));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        Mockend::init();
        RouteRegistrar::registerRoutes();

        /** @var Router $router */
        $router = app(Router::class);
        $router->getRoutes()->refreshNameLookups();
        $this->assertTrue($router->has('TestModel.index'));
        $this->assertTrue($router->has('TestModel.show'));
        $this->assertTrue($router->has('TestModel.store'));
        $this->assertTrue($router->has('TestModel.update'));
        $this->assertTrue($router->has('TestModel.delete'));
        $this->assertTrue($router->has('TestModel.index'));
    }
}
