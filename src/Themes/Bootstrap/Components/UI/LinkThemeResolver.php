<?php

namespace W4\UiFramework\Themes\Bootstrap\Components\UI;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class LinkThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';

        $root = ClassBag::make(['link-offset-2']);

        $root->add(match ($variant) {
            'primary' => 'link-primary',
            'secondary' => 'link-secondary',
            'success' => 'link-success',
            'warning' => 'link-warning',
            'danger', 'error' => 'link-danger',
            'info' => 'link-info',
            'light' => 'link-light',
            'dark' => 'link-dark',
            default => 'link-body-emphasis',
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
            $root->add('disabled opacity-50');
        }

        if ($state === 'active') {
            $root->add('text-decoration-underline');
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
