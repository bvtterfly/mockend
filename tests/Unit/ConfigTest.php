<?php

namespace Tests\Unit;

use App\Exceptions\InvalidConfiguration;
use App\Support\Mockend\Facades\Config;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    /** @test */
    public function it_should_throws_an_invalid_configuration_exception_if_config_file_is_invalid_json()
    {
        $this->expectException(InvalidConfiguration::class);
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn('invalid json');
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        Config::get();
    }

    /** @test */
    public function it_can_get_config()
    {
        $filesystem = Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('get')->andReturn(json_encode([
            'User' => [
                'id' => 'id',
            ],
        ]));
        Storage::shouldReceive('disk', 'base')->andReturn($filesystem);
        $config = Config::get();
        $this->assertTrue($config->has('User'));
    }
}
