<?php

namespace Tests\Unit;

use App\Support\Mockend\Fields\AutoIncrementField;
use App\Support\Mockend\Fields\FakerField;
use App\Support\Mockend\Meta;
use App\Support\Mockend\Mockend;
use App\Support\Mockend\Model;
use App\Support\Mockend\ModelRoute;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class MockendTest extends TestCase
{
    private function getConfig()
    {
        return [
            'User' => [
                '_meta' => [
                    'limit' => 5,
                    'route' => 'new-users',
                ],
                'id' => 'uuid',
            ],
            'Post' => [
                'id' => 'id',
            ],
        ];
    }

    /** @test */
    public function it_can_get_routes()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode($this->getConfig()));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        /** @var Mockend $mockend */
        $mockend = $this->app->make(Mockend::class);
        $mockend->init();
        $routes = $mockend->getRoutes();
        $this->assertEquals(2, $routes->count());
        $this->assertTrue($routes->has('posts'));
        $this->assertTrue($routes->has('new-users'));
        /** @var ModelRoute $postRoute */
        $postRoute = $routes->get('posts');
        $this->assertEquals('Post', $postRoute->model);
        $this->assertEquals(new Meta('Post', true, 10, null), $postRoute->meta);
        /** @var ModelRoute $userRoute */
        $userRoute = $routes->get('new-users');
        $this->assertEquals('User', $userRoute->model);
        $this->assertEquals(new Meta('User', true, 5, 'new-users'), $userRoute->meta);
    }

    /** @test */
    public function it_can_get_models()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode($this->getConfig()));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        /** @var Mockend $mockend */
        $mockend = $this->app->make(Mockend::class);
        $mockend->init();
        $models = $mockend->getModels();
        $this->assertEquals(2, $models->count());
        $this->assertTrue($models->has('Post'));
        $this->assertTrue($models->has('User'));
        /** @var Model $model */
        $model = $models->get('Post');
        $this->assertEquals('Post', $model->name);
        $fields = $model->fields;
        $this->assertEquals(1, $fields->count());
        $this->assertTrue($fields->has('id'));
        $this->assertInstanceOf(AutoIncrementField::class, $fields->get('id'));
        $model = $models->get('User');
        $this->assertEquals('User', $model->name);
        $fields = $model->fields;
        $this->assertEquals(1, $fields->count());
        $this->assertTrue($fields->has('id'));
        $this->assertInstanceOf(FakerField::class, $fields->get('id'));
    }

    /** @test */
    public function it_can_have_non_crud_model()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode([
            'User' => [
                '_meta' => [
                    'crud' => false,
                ],
                'id' => 'uuid',
            ],
        ]));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        /** @var Mockend $mockend */
        $mockend = $this->app->make(Mockend::class);
        $mockend->init();
        $models = $mockend->getModels();
        $routes = $mockend->getRoutes();
        $this->assertEquals(1, $models->count());
        $this->assertEquals(0, $routes->count());
    }
}
