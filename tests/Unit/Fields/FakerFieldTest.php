<?php

namespace Tests\Unit\Fields;

use function app;
use App\Support\Mockend\Fields\FakerField;
use Faker\Generator;
use Mockery;
use Tests\TestCase;

class FakerFieldTest extends TestCase
{
    /** @test */
    public function it_is_not_a_relation_field()
    {
        $field = new FakerField('__TEST__');
        $this->assertFalse($field->isRelation());
    }

    /** @test */
    public function it_should_call_faker_method()
    {
        $faker = Mockery::mock(Generator::class);
        $faker->shouldReceive('testMethod')
              ->with(1, 2, 3)
              ->andReturn('1,2,3');
        app()->instance(Generator::class, $faker);
        $field = new FakerField('testMethod', [1, 2, 3]);
        $this->assertEquals('1,2,3', $field->get());
        $faker = Mockery::mock(Generator::class);
        $faker->shouldReceive('testMethod')
              ->with()
              ->andReturn('test');
        app()->instance(Generator::class, $faker);
        $field = new FakerField('testMethod');
        $this->assertEquals('test', $field->get());
    }
}
