<?php

namespace W4\UI\Framework\Support;

class AttributeBag
{
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public static function make(array $attributes = []): static
    {
        return new static($attributes);
    }

    public function set(string $key, mixed $value): static
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->attributes[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
    }

    public function merge(array $attributes): static
    {
        foreach ($attributes as $key => $value) {
            if ($key === 'class') {
                $existing = $this->attributes['class'] ?? '';
                $incoming = is_array($value) ? implode(' ', $value) : (string) $value;
                $this->attributes['class'] = trim($existing . ' ' . $incoming);
                continue;
            }

            $this->attributes[$key] = $value;
        }

        return $this;
    }

    public function forget(string $key): static
    {
        unset($this->attributes[$key]);

        return $this;
    }

    public function all(): array
    {
        return $this->attributes;
    }

    public function toArray(): array
    {
        return $this->all();
    }
}