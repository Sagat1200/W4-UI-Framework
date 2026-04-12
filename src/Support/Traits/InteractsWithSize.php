<?php

namespace W4\UI\Framework\Support\Traits;

trait InteractsWithSize
{
    protected ?string $size = null;

    public function size(?string $size = null): string|static|null
    {
        if ($size === null) {
            return $this->size;
        }

        $this->size = $size;

        return $this;
    }

    public function hasSize(): bool
    {
        return $this->size !== null && $this->size !== '';
    }

    public function isSize(string $size): bool
    {
        return $this->size === $size;
    }

    public function xs(): static
    {
        return $this->size('xs');
    }

    public function sm(): static
    {
        return $this->size('sm');
    }

    public function md(): static
    {
        return $this->size('md');
    }

    public function lg(): static
    {
        return $this->size('lg');
    }

    public function xl(): static
    {
        return $this->size('xl');
    }
}
