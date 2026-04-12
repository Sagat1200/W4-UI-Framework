<?php

namespace W4\UI\Framework\Core;

use W4\UI\Framework\Contracts\ComponentThemeResolverInterface;
use W4\UI\Framework\Contracts\ThemeInterface;

abstract class AbstractTheme implements ThemeInterface
{
    /**
     * @var array<string, ComponentThemeResolverInterface>
     */
    protected array $resolvers = [];

    abstract public function name(): string;

    public function resolverFor(string $component): ?ComponentThemeResolverInterface
    {
        return $this->resolvers[$component] ?? null;
    }

    public function registerResolver(string $component, ComponentThemeResolverInterface $resolver): static
    {
        $this->resolvers[$component] = $resolver;

        return $this;
    }

    public function resolvers(): array
    {
        return $this->resolvers;
    }
}