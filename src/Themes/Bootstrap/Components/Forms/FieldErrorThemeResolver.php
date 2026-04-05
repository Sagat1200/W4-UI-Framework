<?php

namespace W4\UiFramework\Themes\Bootstrap\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class FieldErrorThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'error';
        $size = $context['size'] ?? 'sm';
        $state = $context['state'] ?? 'enabled';

        $root = ClassBag::make(['invalid-feedback', 'd-block']);

        $root->add(match ($variant) {
            'neutral' => 'text-body-secondary',
            'primary' => 'text-primary',
            'secondary' => 'text-secondary',
            'accent' => 'text-info',
            'success' => 'text-success',
            'warning' => 'text-warning',
            'info' => 'text-info',
            'danger', 'error' => 'text-danger',
            default => 'text-danger',
        });

        $root->add(match ($size) {
            'xs' => 'fs-6',
            'sm' => 'fs-6',
            'md' => 'fs-5',
            'lg' => 'fs-4',
            'xl' => 'fs-3',
            default => 'fs-6',
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
            'code' => 'me-1 fw-semibold',
            'hint' => 'ms-1 small opacity-75',
        ];
    }

    public function attributes(array $context = []): array
    {
        $state = $context['state'] ?? 'enabled';
        $userAttributes = $context['attributes'] ?? [];

        return array_merge($userAttributes, [
            'role' => $userAttributes['role'] ?? 'alert',
            'aria-live' => $state === 'active' ? 'assertive' : 'polite',
            'aria-hidden' => $state === 'hidden' ? 'true' : 'false',
            'data-state' => $state,
            'data-for-field' => $context['for_field'] ?? null,
            'data-error-code' => $context['code'] ?? null,
        ]);
    }
}
