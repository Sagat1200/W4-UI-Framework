<?php

namespace W4\UI\Framework\Support\Traits;

use W4\UI\Framework\Support\AttributeBag;

trait InteractsWithAttributes
{
    protected AttributeBag $attributes;

    protected function initializeInteractsWithAttributes(): void
    {
        $this->attributes = AttributeBag::make();
    }

    public function attribute(string $key, mixed $value): static
    {
        $this->attributes->set($key, $value);

        return $this;
    }

    public function attributes(?array $attributes = null): AttributeBag|static
    {
        if ($attributes === null) {
            return $this->attributes;
        }

        $this->attributes->merge($attributes);

        return $this;
    }

    public function getAttribute(string $key, mixed $default = null): mixed
    {
        return $this->attributes->get($key, $default);
    }

    public function hasAttribute(string $key): bool
    {
        return $this->attributes->has($key);
    }

    public function forgetAttribute(string $key): static
    {
        $this->attributes->forget($key);

        return $this;
    }

    public function attributesToArray(): array
    {
        return $this->attributes->toArray();
    }
}
