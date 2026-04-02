<?php

namespace W4\UiFramework\Themes\DaisyUI\Components\UI;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class ButtonThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'primary';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';

        $classes = ClassBag::make('btn');

        $classes->add(match ($variant) {
            'neutral' => 'btn-neutral',
            'secondary' => 'btn-secondary',
            'accent' => 'btn-accent',
            'success' => 'btn-success',
            'warning' => 'btn-warning',
            'info' => 'btn-info',
            'error', 'danger' => 'btn-error',
            default => 'btn-primary',
        });

        match ($size) {
            'xs' => $classes->add('btn-xs'),
            'sm' => $classes->add('btn-sm'),
            'md' => $classes->add('btn'),
            'lg' => $classes->add('btn-lg'),
            'xl' => $classes->add('btn-xl'),
            default => null,
        };

        if ($state === 'loading') {
            $classes->add('loading');
        }

        if ($state === 'active') {
            $classes->add('btn-active');
        }

        if (! empty($context['attributes']['class'])) {
            $classes->merge($context['attributes']['class']);
        }

        return [
            'root' => $classes->toString(),
        ];
    }

    public function attributes(array $context = []): array
    {
        $state = $context['state'] ?? 'enabled';
        $userAttributes = $context['attributes'] ?? [];

        return array_merge($userAttributes, [
            'type' => $userAttributes['type'] ?? 'button',
            'disabled' => in_array($state, ['disabled', 'loading', 'readonly'], true),
            'aria-disabled' => in_array($state, ['disabled', 'loading', 'readonly'], true) ? 'true' : 'false',
            'aria-pressed' => $state === 'active' ? 'true' : 'false',
        ]);
    }
}
