<?php

namespace W4\UI\Framework\Support\Traits;

use W4\UI\Framework\Support\ComponentMetadata;

trait InteractsWithMetadata
{
    protected ComponentMetadata $meta;

    protected function initializeInteractsWithMetadata(): void
    {
        $this->meta = ComponentMetadata::make();
    }

    public function meta(string $key, mixed $value): static
    {
        $this->meta->set($key, $value);

        return $this;
    }

    public function metadata(?array $metadata = null): ComponentMetadata|static
    {
        if ($metadata === null) {
            return $this->meta;
        }

        $this->meta->merge($metadata);

        return $this;
    }

    public function getMeta(string $key, mixed $default = null): mixed
    {
        return $this->meta->get($key, $default);
    }

    public function hasMeta(string $key): bool
    {
        return $this->meta->has($key);
    }

    public function forgetMeta(string $key): static
    {
        $this->meta->forget($key);

        return $this;
    }

    public function metadataToArray(): array
    {
        return $this->meta->toArray();
    }
}
