<?php

namespace W4\UiFramework\Themes\Bootstrap\Components\UI;

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
            'secondary' => 'btn-secondary',
            'success' => 'btn-success',
            'danger' => 'btn-danger',
            'warning' => 'btn-warning',
            'info' => 'btn-info',
            'light' => 'btn-light',
            'dark' => 'btn-dark',
            'link' => 'btn-link',
            default => 'btn-primary',
        });

        match ($size) {
            'sm' => $classes->add('btn-sm'),
            'lg' => $classes->add('btn-lg'),
            default => null,
        };

        if (in_array($state, ['disabled', 'readonly'], true)) {
            $classes->add('disabled');
        }

        if ($state === 'loading') {
            $classes->add('disabled');
        }

        if ($state === 'active') {
            $classes->add('active');
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
