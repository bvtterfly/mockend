<?php

namespace App\Support\Mockend;

class ModelRoute
{
    public function __construct(
        public string $model,
        public Meta $meta,
    ) {
    }
}
