<?php

namespace W4\UiFramework\Themes\Tailwind\Components\UI;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class HeadingThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';

        $root = ClassBag::make(['font-semibold', 'leading-tight', 'tracking-tight']);

        $root->add(match ($variant) {
            'primary' => 'text-blue-600',
            'secondary' => 'text-slate-700',
            'accent' => 'text-violet-600',
            'success' => 'text-emerald-600',
            'warning' => 'text-amber-600',
            'error' => 'text-rose-600',
            'info' => 'text-cyan-600',
            default => 'text-slate-900',
        });

        $root->add(match ($size) {
            'xs' => 'text-sm',
            'sm' => 'text-base',
            'md' => 'text-xl',
            'lg' => 'text-2xl',
            'xl' => 'text-3xl',
            default => 'text-xl',
        });

        if ($state === 'disabled') {
            $root->add('opacity-50');
        }

        if ($state === 'active') {
            $root->add('underline underline-offset-4');
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
