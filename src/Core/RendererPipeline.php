<?php

namespace W4\UI\Framework\Core;

use InvalidArgumentException;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\Managers\RendererManager;

class RendererPipeline
{
    public function __construct(
        protected RendererManager $rendererManager
    ) {}

    public function render(
        ComponentInterface $component,
        array $resolvedTheme = [],
        ?string $renderer = null
    ): mixed {
        $driver = $renderer ?? config('w4-ui-framework.renderer', 'blade');

        $rendererInstance = $this->rendererManager->driver($driver);

        if (! method_exists($rendererInstance, 'render')) {
            throw new InvalidArgumentException("El renderizador [{$driver}] no tiene un método de render().");
        }

        return $rendererInstance->render($component, $resolvedTheme);
    }
}
