<?php

namespace App\Support\Mockend\Fields;

interface Field
{
    public function isRelation(): bool;

    public function get(): mixed;
}
