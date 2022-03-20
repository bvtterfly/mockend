<?php

namespace App\Support\Mockend\Fields;

class AutoIncrementField implements Field
{
    private static $services = [];

    protected static function getIdFor(string $service)
    {
        if (isset(self::$services[$service])) {
            self::$services[$service]++;

            return self::$services[$service];
        }
        self::$services[$service] = 1;

        return 1;
    }

    public function __construct(protected string $service)
    {
    }

    public function get(): mixed
    {
        return self::getIdFor($this->service);
    }

    public function isRelation(): bool
    {
        return false;
    }
}
