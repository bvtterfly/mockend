<?php

namespace App\Support\Mockend;

use App\Support\Mockend\Fields\Field;
use App\Support\Mockend\Fields\GeneratorField;
use App\Support\Mockend\Fields\RelationField;
use Illuminate\Support\Collection;

class Factory
{
    public function __construct(
        public Model $model,
        protected array $parentModels = []
    ) {
    }

    protected function getAttributes()
    {
        return $this->model->fields
            ->map(function (Field $field) {
                if ($field instanceof RelationField) {
                    return $this->getRelationFieldValue($field);
                }
                if ($field instanceof GeneratorField) {
                    return $field->get();
                }

                return new MissingValue();
            })->reject(fn ($value) => $value instanceof LoadedValue || $value instanceof MissingValue);
    }

    public function create($count = 1, $returnArray = false)
    {
        $models = Collection::times($count)->map(function () {
            return $this->getAttributes();
        });

        if (! $returnArray && $count === 1) {
            return $models->first();
        }

        return $models;
    }

    private function addParentModels(array $parentModels)
    {
        $this->parentModels = [...$this->parentModels, ...$parentModels];
    }

    public function loadedModels(string $model): bool
    {
        return in_array($model, $this->parentModels);
    }

    /**
     * @param  RelationField  $field
     *
     * @return mixed
     */
    protected function getRelationFieldValue(RelationField $field): mixed
    {
        $model = $field->model();
        $factory = $model->getFactory();
        $factory->addParentModels([...$this->parentModels, $this->model->name]);
        if ($factory->loadedModels($model->name)) {
            return new LoadedValue();
        }

        return $factory->create($field->count(), $field->manyRelation());
    }
}
