<?php

namespace W4\UI\Framework\Managers;

use W4\UI\Framework\Contracts\ThemeInterface;

class ThemeManager
{
    /**
     * @var array<string, ThemeInterface>
     */
    protected array $themes = [];

    public function register(string $key, ThemeInterface $theme): static
    {
        $this->themes[$key] = $theme;

        return $this;
    }

    public function resolve(?string $key): ?ThemeInterface
    {
        if ($key === null) {
            return null;
        }

        return $this->themes[$key] ?? null;
    }

    public function currentTheme(): string
    {
        return config('w4-ui-framework.theme', 'w4native');
    }

    public function all(): array
    {
        return $this->themes;
    }
}