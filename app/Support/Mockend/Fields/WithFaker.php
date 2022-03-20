<?php

namespace App\Support\Mockend\Fields;

use Faker\Generator;

trait WithFaker
{
    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return app()->make(Generator::class);
    }
}
