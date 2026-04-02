<?php

namespace W4\UiFramework\Core;

use InvalidArgumentException;
use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\Managers\RendererManager;

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
        $driver = $renderer ?? config('w4_ui_framework.renderer', 'blade');

        $rendererInstance = $this->rendererManager->driver($driver);

        if (! method_exists($rendererInstance, 'render')) {
            throw new InvalidArgumentException("El renderizador [{$driver}] no tiene un método de render().");
        }

        return $rendererInstance->render($component, $resolvedTheme);
    }
}
