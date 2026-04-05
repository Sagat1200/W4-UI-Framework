<?php

namespace W4\UiFramework\Themes\Tailwind\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class HelperTextThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'sm';
        $state = $context['state'] ?? 'enabled';

        $root = ClassBag::make(['mt-1', 'block', 'text-slate-500']);

        $root->add(match ($variant) {
            'neutral', 'default' => 'text-slate-500',
            'primary' => 'text-blue-600',
            'secondary' => 'text-slate-700',
            'accent' => 'text-violet-600',
            'success' => 'text-emerald-600',
            'warning' => 'text-amber-600',
            'error', 'danger' => 'text-rose-600',
            'info' => 'text-cyan-600',
            default => 'text-slate-500',
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
            $root->add('font-medium');
        }

        if ($state === 'hidden') {
            $root->add('hidden');
        }

        if (! empty($context['attributes']['class'])) {
            $root->merge((string) $context['attributes']['class']);
        }

        return [
            'root' => $root->toString(),
            'icon' => 'mr-1 inline-flex items-center',
            'text' => 'inline',
        ];
    }

    public function attributes(array $context = []): array
    {
        $state = $context['state'] ?? 'enabled';
        $userAttributes = $context['attributes'] ?? [];
        $interactState = $context['interact_state'] ?? [];

        return array_merge($userAttributes, [
            'role' => $userAttributes['role'] ?? 'note',
            'aria-live' => $state === 'active' ? 'polite' : 'off',
            'aria-hidden' => $state === 'hidden' ? 'true' : 'false',
            'data-state' => $state,
            'data-for-field' => $context['for_field'] ?? null,
            'data-focused' => ($interactState['focused'] ?? false) ? 'true' : 'false',
            'data-hovered' => ($interactState['hovered'] ?? false) ? 'true' : 'false',
        ]);
    }
}
