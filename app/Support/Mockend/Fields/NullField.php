<?php

namespace App\Support\Mockend\Fields;

class NullField implements Field
{
    public function get(): mixed
    {
        return null;
    }

    public function isRelation(): bool
    {
        return false;
    }
}
