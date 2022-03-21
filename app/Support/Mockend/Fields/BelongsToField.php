<?php

namespace App\Support\Mockend\Fields;

use App\Exceptions\InvalidConfiguration;
use App\Support\Mockend\Facades\Mockend;

class BelongsToField implements Field
{
    public function __construct(protected string $model)
    {
    }

    public function get(): mixed
    {
        $model = Mockend::getModel($this->model);
        if (! $model) {
            throw InvalidConfiguration::model($this->model);
        }
        $factory = $model->getFactory();
        $factory->withoutRelationFields();

        return $factory->create();
    }

    public function isRelation(): bool
    {
        return true;
    }
}
