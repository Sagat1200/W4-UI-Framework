<?php

namespace W4\UiFramework\Themes\Bootstrap\Components\UI;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class TextThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';

        $root = ClassBag::make(['d-inline-block']);

        $root->add(match ($variant) {
            'primary' => 'text-primary',
            'secondary' => 'text-secondary',
            'success' => 'text-success',
            'warning' => 'text-warning',
            'danger', 'error' => 'text-danger',
            'info' => 'text-info',
            'light' => 'text-light',
            'dark' => 'text-dark',
            default => 'text-body',
        });

        $root->add(match ($size) {
            'xs' => 'fs-6',
            'sm' => 'fs-5',
            'md' => 'fs-4',
            'lg' => 'fs-3',
            'xl' => 'fs-2',
            default => 'fs-4',
        });

        if ($state === 'disabled') {
            $root->add('opacity-50');
        }

        if ($state === 'active') {
            $root->add('fw-semibold');
        }

        if ($state === 'hidden') {
            $root->add('d-none');
        }

        if (! empty($context['attributes']['class'])) {
            $root->merge((string) $context['attributes']['class']);
        }

        return [
            'root' => $root->toString(),
        ];
    }

    public function attributes(array $context = []): array
    {
        $state = $context['state'] ?? 'enabled';
        $userAttributes = $context['attributes'] ?? [];

        return array_merge($userAttributes, [
            'role' => $userAttributes['role'] ?? 'text',
            'aria-hidden' => $state === 'hidden' ? 'true' : 'false',
            'data-state' => $state,
        ]);
    }
}
