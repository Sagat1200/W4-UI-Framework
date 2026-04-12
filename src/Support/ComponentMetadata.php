<?php

namespace W4\UI\Framework\Support;

class ComponentMetadata
{
    protected array $metadata = [];

    public function __construct(array $metadata = [])
    {
        $this->metadata = $metadata;
    }

    public static function make(array $metadata = []): static
    {
        return new static($metadata);
    }

    public function set(string $key, mixed $value): static
    {
        $this->metadata[$key] = $value;

        return $this;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->metadata[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->metadata);
    }

    public function merge(array $metadata): static
    {
        $this->metadata = array_merge($this->metadata, $metadata);

        return $this;
    }

    public function forget(string $key): static
    {
        unset($this->metadata[$key]);

        return $this;
    }

    public function all(): array
    {
        return $this->metadata;
    }

    public function toArray(): array
    {
        return $this->all();
    }
}
