<?php

namespace W4\UiFramework\Themes\Bootstrap\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class RadioThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'default';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';
        $interactState = $context['interact_state'] ?? [];

        $inputClasses = ClassBag::make('form-check-input');

        match ($size) {
            'sm' => $inputClasses->add('form-check-input-sm'),
            'lg' => $inputClasses->add('form-check-input-lg'),
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

        if (($interactState['focused'] ?? false) === true) {
            $inputClasses->add('focus');
        }

        if (! empty($context['attributes']['class'])) {
            $inputClasses->merge((string) $context['attributes']['class']);
        }

        return [
            'root' => 'form-check',
            'label' => 'form-check-label',
            'input' => $inputClasses->toString(),
            'text' => '',
            'helper' => 'form-text',
            'error' => 'invalid-feedback d-block',
        ];
    }

    public function attributes(array $context = []): array
    {
        $state = $context['state'] ?? 'enabled';
        $userAttributes = $context['attributes'] ?? [];
        $interactState = $context['interact_state'] ?? [];
        $selected = (bool) ($context['selected'] ?? false);

        return array_merge($userAttributes, [
            'type' => 'radio',
            'name' => $context['group'] ?? $context['name'] ?? $userAttributes['name'] ?? null,
            'id' => $context['id'] ?? $userAttributes['id'] ?? null,
            'value' => $context['value'] ?? $userAttributes['value'] ?? null,
            'checked' => $selected,
            'disabled' => in_array($state, ['disabled', 'loading'], true),
            'readonly' => $state === 'readonly',
            'aria-invalid' => $state === 'invalid' ? 'true' : 'false',
            'aria-busy' => $state === 'loading' ? 'true' : 'false',
            'aria-checked' => $selected ? 'true' : 'false',
            'data-focused' => ($interactState['focused'] ?? false) ? 'true' : 'false',
            'data-hovered' => ($interactState['hovered'] ?? false) ? 'true' : 'false',
            'data-pressed' => ($interactState['pressed'] ?? false) ? 'true' : 'false',
        ]);
    }
}