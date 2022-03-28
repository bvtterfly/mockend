<?php

namespace App\Support\Mockend\Fields;

use App\Support\Mockend\Facades\Mockend;
use App\Support\Mockend\Factory;
use App\Support\Mockend\Model;

abstract class RelationField implements Field
{
    protected int $count;

    public function __construct(protected string $modelName)
    {
        $this->count = $this->initCount();
    }

    public function model(): Model
    {
        return Mockend::getModel($this->modelName);
    }

    public function modelName(): string
    {
        return $this->modelName;
    }

    public function getFactory(): Factory
    {
        return $this->model()->getFactory();
    }

    protected function initCount(): int
    {
        return 1;
    }

    public function manyRelation(): bool
    {
        return false;
    }

    public function count(): int
    {
        return $this->count;
    }
}
