<?php

namespace App\Support\Mockend;

use Illuminate\Support\Str;

class Meta
{
    public function __construct(
        public string $model,
        public bool $crud,
        public int $limit,
        public ?string $route = null,
    ) {
    }

    public function getRoute(): string
    {
        return $this->route ?? Str::of($this->model)
                                  ->pluralStudly()
                                  ->snake()
                                  ->slug()->value();
    }

    public static function fromArray(string $model, array $meta): self
    {
        return new self(
            $model,
            $meta['crud'],
            $meta['limit'],
            $meta['route'] ?? null,
        );
    }

    public static function getDefaultValue(): array
    {
        return [
            'crud' => true,
            'limit' => 10,
        ];
    }
}
