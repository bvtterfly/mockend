<?php

namespace App\Support\Mockend\Fields;

class HasManyField extends RelationField
{
    protected function initCount(): int
    {
        return rand(0, 10);
    }

    public function manyRelation(): bool
    {
        return true;
    }
}
