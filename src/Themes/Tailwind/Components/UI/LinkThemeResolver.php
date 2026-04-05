<?php

namespace W4\UiFramework\Themes\Tailwind\Components\UI;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class LinkThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';

        $root = ClassBag::make(['inline-flex', 'items-center', 'underline', 'underline-offset-4', 'transition']);

        $root->add(match ($variant) {
            'primary' => 'text-blue-600 hover:text-blue-700',
            'secondary' => 'text-slate-700 hover:text-slate-800',
            'accent' => 'text-violet-600 hover:text-violet-700',
            'success' => 'text-emerald-600 hover:text-emerald-700',
            'warning' => 'text-amber-600 hover:text-amber-700',
            'error', 'danger' => 'text-rose-600 hover:text-rose-700',
            'info' => 'text-cyan-600 hover:text-cyan-700',
            default => 'text-slate-900 hover:text-slate-700',
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
            $root->add('opacity-50 pointer-events-none');
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
        ];
    }

    public function attributes(array $context = []): array
    {
        $state = $context['state'] ?? 'enabled';
        $userAttributes = $context['attributes'] ?? [];

        return array_merge($userAttributes, [
            'href' => $userAttributes['href'] ?? ($context['href'] ?? '#'),
            'target' => $userAttributes['target'] ?? ($context['target'] ?? null),
            'rel' => $userAttributes['rel'] ?? ($context['rel'] ?? null),
            'aria-disabled' => $state === 'disabled' ? 'true' : 'false',
            'tabindex' => $state === 'disabled' ? '-1' : ($userAttributes['tabindex'] ?? null),
            'aria-hidden' => $state === 'hidden' ? 'true' : 'false',
            'data-state' => $state,
        ]);
    }
}
