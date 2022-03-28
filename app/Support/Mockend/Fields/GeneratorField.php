<?php

namespace App\Support\Mockend\Fields;

interface GeneratorField extends Field
{
    public function get(): mixed;
}
