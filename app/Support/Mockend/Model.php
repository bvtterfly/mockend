<?php

namespace App\Support\Mockend;

use Illuminate\Support\Collection;

class Model
{
    public function __construct(
        public string $name,
        public Collection $fields,
    ) {
    }

    public function getFactory(): Factory
    {
        return new Factory($this);
    }
}
