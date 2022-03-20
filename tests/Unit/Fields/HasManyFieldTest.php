<?php

namespace Tests\Unit\Fields;

use App\Exceptions\InvalidConfiguration;
use App\Support\Mockend\Fields\HasManyField;
use App\Support\Mockend\Mockend;
use function collect;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class HasManyFieldTest extends TestCase
{
    private function getConfig()
    {
        return [
            'User' => [
                'posts' => [
                    'belongsTo' => 'Post',
                ],
            ],
            'Post' => [
                'id' => [
                    'value' => 1,
                ],
            ],
        ];
    }

    /** @test */
    public function it_is_a_relation_field()
    {
        $field = new HasManyField('__TEST__');
        $this->assertTrue($field->isRelation());
    }

    /** @test */
    public function it_should_generate_from_model()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode($this->getConfig()));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        Mockend::init();
        $field = new HasManyField('Post');
        $this->assertEquals(Collection::times(5)->map(fn () => collect(['id' => 1])), $field->get());
    }

    /** @test */
    public function it_should_throw_an_exception_if_model_doesnt_exists()
    {
        $this->expectException(InvalidConfiguration::class);
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode($this->getConfig()));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        Mockend::init();
        $field = new HasManyField('Salam');
        $field->get();
    }
}
