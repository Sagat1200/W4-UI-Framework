<?php

namespace W4\UI\Framework\Contracts;

use W4\UI\Framework\Contracts\ComponentThemeResolverInterface;

interface ThemeInterface
{
    public function name(): string;

    public function resolverFor(string $component): ?ComponentThemeResolverInterface;
}