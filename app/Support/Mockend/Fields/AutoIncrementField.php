<?php

namespace App\Support\Mockend\Fields;

class AutoIncrementField implements Field
{
    private SequenceGenerator $sequenceGenerator;

    public function __construct(protected string $service)
    {
        $this->sequenceGenerator = app(SequenceGenerator::class);
    }

    public function get(): mixed
    {
        return $this->sequenceGenerator->getNext($this->service);
    }

    public function isRelation(): bool
    {
        return false;
    }
}
