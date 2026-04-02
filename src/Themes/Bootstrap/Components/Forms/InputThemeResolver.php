<?php

namespace W4\UiFramework\Themes\Bootstrap\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class InputThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'default';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';

        $inputClasses = ClassBag::make('form-control');

        match ($size) {
            'sm' => $inputClasses->add('form-control-sm'),
            'lg' => $inputClasses->add('form-control-lg'),
            default => null,
        };

        match ($variant) {
            'success' => $inputClasses->add('is-valid'),
            'danger', 'error' => $inputClasses->add('is-invalid'),
            'warning' => $inputClasses->add('border-warning'),
            default => null,
        };

        match ($state) {
            'valid' => $inputClasses->add('is-valid'),
            'invalid' => $inputClasses->add('is-invalid'),
            'loading' => $inputClasses->add('opacity-75'),
            default => null,
        };

        if (! empty($context['attributes']['class'])) {
            $inputClasses->merge($context['attributes']['class']);
        }

        return [
            'root' => 'w-100',
            'input' => $inputClasses->toString(),
            'helper' => 'form-text',
            'error' => 'invalid-feedback d-block',
            'label' => 'form-label',
        ];
    }

    public function attributes(array $context = []): array
    {
        $state = $context['state'] ?? 'enabled';
        $userAttributes = $context['attributes'] ?? [];

        return array_merge($userAttributes, [
            'type' => $context['type'] ?? $userAttributes['type'] ?? 'text',
            'name' => $context['name'] ?? $userAttributes['name'] ?? null,
            'id' => $context['id'] ?? $userAttributes['id'] ?? null,
            'value' => $context['value'] ?? $userAttributes['value'] ?? null,
            'placeholder' => $context['placeholder'] ?? $userAttributes['placeholder'] ?? null,
            'disabled' => in_array($state, ['disabled', 'loading'], true),
            'readonly' => $state === 'readonly',
            'aria-invalid' => in_array($state, ['invalid'], true) ? 'true' : 'false',
        ]);
    }
}
