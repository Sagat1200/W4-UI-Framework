<?php

namespace W4\UiFramework\Themes\Bootstrap\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class HelperTextThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'sm';
        $state = $context['state'] ?? 'enabled';

        $root = ClassBag::make('form-text');

        $root->add(match ($variant) {
            'neutral', 'default' => 'text-body-secondary',
            'primary' => 'text-primary',
            'secondary' => 'text-secondary',
            'accent' => 'text-info',
            'success' => 'text-success',
            'warning' => 'text-warning',
            'error', 'danger' => 'text-danger',
            'info' => 'text-info',
            default => 'text-body-secondary',
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
            $root->add('fw-medium');
        }

        if ($state === 'hidden') {
            $root->add('d-none');
        }

        if (! empty($context['attributes']['class'])) {
            $root->merge((string) $context['attributes']['class']);
        }

        return [
            'root' => $root->toString(),
            'icon' => 'me-1 d-inline-flex align-items-center',
            'text' => 'd-inline',
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
