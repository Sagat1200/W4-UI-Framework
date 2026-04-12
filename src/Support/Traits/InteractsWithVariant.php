<?php

namespace W4\UI\Framework\Support\Traits;

trait InteractsWithVariant
{
    protected ?string $variant = null;

    public function variant(?string $variant = null): string|static|null
    {
        if ($variant === null) {
            return $this->variant;
        }

        $this->variant = $variant;

        return $this;
    }

    public function hasVariant(): bool
    {
        return $this->variant !== null && $this->variant !== '';
    }

    public function isVariant(string $variant): bool
    {
        return $this->variant === $variant;
    }

    public function primary(): static
    {
        return $this->variant('primary');
    }

    public function secondary(): static
    {
        return $this->variant('secondary');
    }

    public function success(): static
    {
        return $this->variant('success');
    }

    public function danger(): static
    {
        return $this->variant('danger');
    }

    public function warning(): static
    {
        return $this->variant('warning');
    }

    public function info(): static
    {
        return $this->variant('info');
    }
}