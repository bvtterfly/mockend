<?php

namespace App\Support\Mockend;

use App\Support\Mockend\Fields\Field;
use Illuminate\Support\Collection;

class Factory
{
    private bool $withRelationField = true;

    public function __construct(
        public Model $model,
    ) {
    }

    public function withoutRelationFields()
    {
        $this->withRelationField = false;
    }

    protected function getAttributes()
    {
        return $this->model->fields->when(! $this->withRelationField, function (Collection $fields) {
            return $fields->reject(fn (Field $field) => $field->isRelation());
        })->map(function (Field $field) {
            return $field->get();
        });
    }

    public function create($count = 1)
    {
        $models = Collection::times($count)->map(function () {
            return $this->getAttributes();
        });

        if ($count === 1) {
            return $models->first();
        }

        return $models;
    }
}
