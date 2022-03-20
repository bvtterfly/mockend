<?php

namespace App\Support\Mockend\Fields;

use Faker\Generator;

class RandomField implements Field
{
    use WithFaker;

    private Generator $faker;

    public function __construct(protected array $args)
    {
        $this->faker = $this->withFaker();
    }

    public function get(): mixed
    {
        return $this->faker->randomElement($this->args);
    }

    public function isRelation(): bool
    {
        return false;
    }
}
