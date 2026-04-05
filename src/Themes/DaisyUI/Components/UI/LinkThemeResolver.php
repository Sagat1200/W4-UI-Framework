<?php

namespace W4\UiFramework\Themes\DaisyUI\Components\UI;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class LinkThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';

        $root = ClassBag::make(['link']);

        $root->add(match ($variant) {
            'primary' => 'link-primary',
            'secondary' => 'link-secondary',
            'accent' => 'link-accent',
            'success' => 'link-success',
            'warning' => 'link-warning',
            'error', 'danger' => 'link-error',
            'info' => 'link-info',
            default => 'link-neutral',
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
            $root->add('link-hover font-semibold');
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
