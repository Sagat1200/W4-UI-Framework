<?php

namespace W4\UI\Framework\Support\Traits;

trait InteractsWithLabel
{
    protected ?string $label = null;

    public function label(?string $label = null): string|static|null
    {
        if ($label === null) {
            return $this->label;
        }

        $this->label = $label;

        return $this;
    }

    public function hasLabel(): bool
    {
        return $this->label !== null && $this->label !== '';
    }
}
