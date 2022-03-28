<?php

namespace Tests\Unit;

use App\Support\Mockend\Factory;
use App\Support\Mockend\Fields\Field;
use App\Support\Mockend\Fields\GeneratorField;
use App\Support\Mockend\Fields\RelationField;
use App\Support\Mockend\Mockend;
use App\Support\Mockend\Model;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    private function getConfig()
    {
        return [
            'User' => [
                'id' => 'uuid',
                'post' => [
                    'hasOne' => 'Post',
                ],
            ],
            'Post' => [
                'id' => 'id',
                'user' => [
                    'belongsTo' => 'User',
                ],
            ],
        ];
    }

    /** @test */
    public function it_can_create_items_from_generator_fields()
    {
        $field = Mockery::mock(GeneratorField::class);
        $field->shouldReceive('get')->andReturn('__VALUE__');
        $model = new Model('__MODEL__', collect(['__FIELD__' => $field]));
        $factory = $model->getFactory();
        $result = $factory->create();
        $this->assertEquals(collect(['__FIELD__' => '__VALUE__']), $result);
    }

    /** @test */
    public function it_can_create_items_from_fields()
    {
        $field = Mockery::mock(Field::class);
        $model = new Model('__MODEL__', collect(['__FIELD__' => $field]));
        $factory = $model->getFactory();
        $result = $factory->create();
        $this->assertEquals(collect([]), $result);
    }

    /** @test */
    public function it_can_create_items_from_relation_fields()
    {
        $field = Mockery::mock(GeneratorField::class);
        $field->shouldReceive('get')->andReturn('__VALUE__');
        $relationModel = new Model('__RELATION_MODEL__', collect(['__FIELD__' => $field]));
        $relationField = Mockery::mock(RelationField::class);
        $relationField->shouldReceive('model')->andReturn($relationModel);
        $relationField->shouldReceive('count')->andReturn(1);
        $relationField->shouldReceive('manyRelation')->andReturn(false);
        $model = new Model('__MODEL__', collect(['__RELATION_FIELD__' => $relationField]));
        $factory = $model->getFactory();
        $result = $factory->create();
        $this->assertEquals(collect([
            '__RELATION_FIELD__' => collect(['__FIELD__' => '__VALUE__']),
        ]), $result);
    }

    /** @test */
    public function it_can_create_items_from_many_relation_fields()
    {
        $field = Mockery::mock(GeneratorField::class);
        $field->shouldReceive('get')->andReturn('__VALUE__');
        $relationModel = new Model('__RELATION_MODEL__', collect(['__FIELD__' => $field]));
        $relationField = Mockery::mock(RelationField::class);
        $relationField->shouldReceive('model')->andReturn($relationModel);
        $relationField->shouldReceive('count')->andReturn(1);
        $relationField->shouldReceive('manyRelation')->andReturn(true);
        $model = new Model('__MODEL__', collect(['__RELATION_FIELD__' => $relationField]));
        $factory = $model->getFactory();
        $result = $factory->create();
        $this->assertEquals(collect([
            '__RELATION_FIELD__' => collect([collect(['__FIELD__' => '__VALUE__'])]),
        ]), $result);
    }

    /** @test */
    public function it_can_prevent_infinite_loops()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode($this->getConfig()));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        /** @var Mockend $mockend */
        $mockend = $this->app->make(Mockend::class);
        $mockend->init();
        $userModel = $mockend->getModel('User');
        $factory = new Factory($userModel);
        $result = $factory->create();
        $this->assertTrue($result->has('id'));
        $this->assertTrue($result->has('post'));
        $post = $result->get('post');
        $this->assertTrue($post->has('id'));
        $this->assertFalse($post->has('user'));
    }
}
