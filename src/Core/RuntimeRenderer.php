<?php

namespace W4\UI\Framework\Core;

use InvalidArgumentException;
use W4\UI\Framework\Contracts\ComponentInterface;

class RuntimeRenderer
{
    public function __construct(
        protected ThemeResolverPipeline $themeResolverPipeline,
        protected RendererPipeline $rendererPipeline
    ) {}

    public function render(ComponentInterface $component, ?string $renderer = null): mixed
    {
        $resolved = $this->themeResolverPipeline->resolve($component);

        return $this->rendererPipeline->render(
            component: $component,
            resolvedTheme: $resolved,
            renderer: $renderer
        );
    }

    public function renderMany(iterable $components, ?string $renderer = null): array
    {
        $output = [];

        foreach ($components as $component) {
            if (! $component instanceof ComponentInterface) {
                throw new InvalidArgumentException('Todos los elementos pasados a renderMany() deben implementar la interfaz ComponentInterface.');
            }

            $output[] = $this->render($component, $renderer);
        }

        return $output;
    }
}
