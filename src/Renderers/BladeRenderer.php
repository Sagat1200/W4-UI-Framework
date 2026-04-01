<?php

namespace W4\UiFramework\Renderers;

use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\Core\AbstractRenderer;

class BladeRenderer extends AbstractRenderer
{
    public function render(ComponentInterface $component, array $resolvedTheme = []): array
    {
        return [
            'renderer' => 'blade',
            'view' => 'w4-ui::components.ui.' . $component->componentName(),
            'component' => $component->componentName(),
            'data' => $component->toArray(),
            'theme' => $resolvedTheme,
        ];
    }
}
