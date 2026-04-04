<?php

namespace W4\UiFramework\Themes\DaisyUI\Components\UI;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class HeadingThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';

        $root = ClassBag::make(['font-semibold', 'leading-tight']);

        $root->add(match ($variant) {
            'primary' => 'text-primary',
            'secondary' => 'text-secondary',
            'accent' => 'text-accent',
            'success' => 'text-success',
            'warning' => 'text-warning',
            'error' => 'text-error',
            'info' => 'text-info',
            default => 'text-base-content',
        });

        $root->add(match ($size) {
            'xs' => 'text-xs',
            'sm' => 'text-sm',
            'md' => 'text-base',
            'lg' => 'text-lg',
            'xl' => 'text-xl',
            default => 'text-base',
        });

        if ($state === 'disabled') {
            $root->add('opacity-50');
        }

        if ($state === 'active') {
            $root->add('underline');
        }

        if ($state === 'hidden') {
            $root->add('hidden');
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
        $level = $context['level'] ?? 'h2';
        $state = $context['state'] ?? 'enabled';
        $userAttributes = $context['attributes'] ?? [];

        return array_merge($userAttributes, [
            'role' => $userAttributes['role'] ?? 'heading',
            'aria-level' => $userAttributes['aria-level'] ?? (int) str_replace('h', '', (string) $level),
            'aria-hidden' => $state === 'hidden' ? 'true' : 'false',
            'data-state' => $state,
        ]);
    }
}
