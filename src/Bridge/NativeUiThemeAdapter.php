<?php

namespace W4\UI\Framework\Bridge;

use W4\UI\Framework\Contracts\ComponentThemeResolverInterface;
use W4\UI\Framework\Contracts\ThemeInterface;

class NativeUiThemeAdapter implements ThemeInterface
{
    /**
     * @var array<string, ComponentThemeResolverInterface>
     */
    protected array $resolvers = [];

    public function __construct(
        protected object $nativeTheme,
        protected string $name = 'w4native'
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function resolverFor(string $component): ?ComponentThemeResolverInterface
    {
        $normalized = strtolower(trim($component));

        if ($normalized === '') {
            return null;
        }

        if (! isset($this->resolvers[$normalized])) {
            $this->resolvers[$normalized] = new NativeUiComponentResolverAdapter(
                $this->nativeTheme,
                $normalized
            );
        }

        return $this->resolvers[$normalized];
    }
}
