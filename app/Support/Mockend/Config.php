<?php

namespace App\Support\Mockend;

use App\Exceptions\InvalidConfiguration;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Config
{
    public function getDisk(): Filesystem
    {
        return Storage::disk(config('mockend.disk'));
    }

    public function getConfigFilePath(): string
    {
        return config('mockend.file_path');
    }

    public function get(): Collection
    {
        $contents = $this->getDisk()->get($this->getConfigFilePath());
        try {
            return collect(json_decode($contents, true, flags: JSON_THROW_ON_ERROR));
        } catch (\Exception $e) {
            throw InvalidConfiguration::config();
        }
    }
}
