<?php

namespace W4\UI\Framework\Contracts;

use W4\UI\Framework\Contracts\ComponentInterface;

interface RendererInterface
{
    public function render(ComponentInterface $component, array $resolvedTheme = []): mixed;
}
