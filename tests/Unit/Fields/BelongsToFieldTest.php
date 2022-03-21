<?php

namespace Tests\Unit\Fields;

use App\Exceptions\InvalidConfiguration;
use App\Support\Mockend\Facades\Mockend;
use App\Support\Mockend\Fields\BelongsToField;
use function collect;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class BelongsToFieldTest extends TestCase
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
    public function it_should_generate_from_model()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode($this->getConfig()));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        Mockend::init();
        $field = new BelongsToField('Post');
        $this->assertEquals(collect(['id' => 1]), $field->get());
    }

    /** @test */
    public function it_should_throw_an_exception_if_model_doesnt_exists()
    {
        $this->expectException(InvalidConfiguration::class);
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode($this->getConfig()));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        Mockend::init();
        $field = new BelongsToField('Salam');
        $field->get();
    }

    /** @test */
    public function it_is_a_relation_field()
    {
        $field = new BelongsToField('__TEST__');
        $this->assertTrue($field->isRelation());
    }
}
