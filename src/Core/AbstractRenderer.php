<?php

namespace W4\UI\Framework\Core;

use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\Contracts\RendererInterface;

abstract class AbstractRenderer implements RendererInterface
{
    abstract public function render(ComponentInterface $component, array $resolvedTheme = []): mixed;

    protected function basePayload(ComponentInterface $component, array $resolvedTheme = []): array
    {
        return [
            'component' => $component->componentName(),
            'data' => $component->toArray(),
            'theme' => $resolvedTheme,
        ];
    }
}