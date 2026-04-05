<?php

namespace W4\UiFramework\Themes\DaisyUI\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class FieldErrorThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'error';
        $size = $context['size'] ?? 'sm';
        $state = $context['state'] ?? 'enabled';

        $root = ClassBag::make(['label-text-alt', 'text-error']);

        $root->add(match ($variant) {
            'neutral' => 'text-base-content',
            'primary' => 'text-primary',
            'secondary' => 'text-secondary',
            'accent' => 'text-accent',
            'success' => 'text-success',
            'warning' => 'text-warning',
            'info' => 'text-info',
            'danger', 'error' => 'text-error',
            default => 'text-error',
        });

        $root->add(match ($size) {
            'xs' => 'text-xs',
            'sm' => 'text-sm',
            'md' => 'text-base',
            'lg' => 'text-lg',
            'xl' => 'text-xl',
            default => 'text-sm',
        });

        if ($state === 'disabled') {
            $root->add('opacity-50');
        }

        if ($state === 'active') {
            $root->add('font-semibold');
        }

        if ($state === 'hidden') {
            $root->add('hidden');
        }

        if (! empty($context['attributes']['class'])) {
            $root->merge((string) $context['attributes']['class']);
        }

        return [
            'root' => $root->toString(),
            'code' => 'mr-1 font-semibold',
            'hint' => 'ml-1 text-xs opacity-80',
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