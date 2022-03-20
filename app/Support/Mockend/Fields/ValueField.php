<?php

namespace App\Support\Mockend\Fields;

class ValueField implements Field
{
    public function __construct(protected mixed $args)
    {
    }

    public function get(): mixed
    {
        return $this->args;
    }

    public function isRelation(): bool
    {
        return false;
    }
}
