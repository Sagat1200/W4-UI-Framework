<?php

namespace W4\UiFramework\Themes\Bootstrap\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class SelectThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'default';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';
        $interactState = $context['interact_state'] ?? [];

        $inputClasses = ClassBag::make('form-select');

        match ($size) {
            'sm' => $inputClasses->add('form-select-sm'),
            'lg' => $inputClasses->add('form-select-lg'),
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

        if (($interactState['focused'] ?? false) === true || ($interactState['opened'] ?? false) === true) {
            $inputClasses->add('focus');
        }

        if (! empty($context['attributes']['class'])) {
            $inputClasses->merge((string) $context['attributes']['class']);
        }

        return [
            'root' => 'mb-3',
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
        $interactState = $context['interact_state'] ?? [];

        return array_merge($userAttributes, [
            'name' => $context['name'] ?? $userAttributes['name'] ?? null,
            'id' => $context['id'] ?? $userAttributes['id'] ?? null,
            'multiple' => (bool) ($context['multiple'] ?? false),
            'disabled' => in_array($state, ['disabled', 'loading'], true),
            'readonly' => $state === 'readonly',
            'aria-invalid' => $state === 'invalid' ? 'true' : 'false',
            'aria-busy' => $state === 'loading' ? 'true' : 'false',
            'data-focused' => ($interactState['focused'] ?? false) ? 'true' : 'false',
            'data-hovered' => ($interactState['hovered'] ?? false) ? 'true' : 'false',
            'data-opened' => ($interactState['opened'] ?? false) ? 'true' : 'false',
        ]);
    }
}
