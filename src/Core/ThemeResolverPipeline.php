<?php

namespace W4\UI\Framework\Core;

use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\Managers\ThemeManager;

class ThemeResolverPipeline
{
    public function __construct(
        protected ThemeManager $themeManager
    ) {}

    public function resolve(ComponentInterface $component): array
    {
        $themeKey = method_exists($component, 'theme') && ($componentTheme = call_user_func([$component, 'theme'])) !== null
            ? call_user_func([$component, 'theme'])
            : $this->themeManager->currentTheme();

        $theme = $this->themeManager->resolve($themeKey);

        if ($theme === null) {
            return $this->fallbackResolution($component, $themeKey);
        }

        $context = $component->toThemeContext();

        $resolver = $theme->resolverFor($component->componentName());

        if ($resolver === null) {
            return $this->fallbackResolution($component, $themeKey);
        }

        return [
            'theme' => $themeKey,
            'component' => $component->componentName(),
            'context' => $context,
            'classes' => $resolver->classes($context),
            'attributes' => $resolver->attributes($context),
            'slots' => [],
        ];
    }

    protected function fallbackResolution(ComponentInterface $component, ?string $themeKey): array
    {
        return [
            'theme' => $themeKey,
            'component' => $component->componentName(),
            'context' => $component->toThemeContext(),
            'classes' => [],
            'attributes' => [],
            'slots' => [],
        ];
    }
}