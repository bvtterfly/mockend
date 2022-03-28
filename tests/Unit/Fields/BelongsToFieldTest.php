<?php

namespace Tests\Unit\Fields;

use App\Exceptions\InvalidConfiguration;
use App\Support\Mockend\Facades\Mockend;
use App\Support\Mockend\Fields\BelongsToField;
use App\Support\Mockend\Fields\RelationField;
use App\Support\Mockend\Model;
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
    public function it_can_get_relatedModelName()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode($this->getConfig()));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        Mockend::init();
        $field = new BelongsToField('Post');
        $this->assertEquals('Post', $field->modelName());
    }

    /** @test */
    public function it_can_get_relatedModel()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode($this->getConfig()));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        Mockend::init();
        $field = new BelongsToField('Post');
        $this->assertInstanceOf(Model::class, $field->model());
    }
}
