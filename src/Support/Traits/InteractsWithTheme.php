<?php

namespace W4\UI\Framework\Support\Traits;

trait InteractsWithTheme
{
    protected ?string $theme = null;

    public function theme(?string $theme = null): string|static|null
    {
        if ($theme === null) {
            return $this->theme;
        }

        $this->theme = $theme;

        return $this;
    }

    public function hasTheme(): bool
    {
        return $this->theme !== null && $this->theme !== '';
    }
}
