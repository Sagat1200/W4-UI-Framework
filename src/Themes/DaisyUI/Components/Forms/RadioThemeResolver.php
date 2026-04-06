<?php

namespace W4\UiFramework\Themes\DaisyUI\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class RadioThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';
        $interactState = $context['interact_state'] ?? [];

        $inputClasses = ClassBag::make(['radio']);

        match ($size) {
            'xs' => $inputClasses->add('radio-xs'),
            'sm' => $inputClasses->add('radio-sm'),
            'md' => $inputClasses->add('radio-md'),
            'lg' => $inputClasses->add('radio-lg'),
            'xl' => $inputClasses->add('radio-lg'),
            default => null,
        };

        match ($variant) {
            'neutral', 'default' => $inputClasses->add('radio-neutral'),
            'primary' => $inputClasses->add('radio-primary'),
            'secondary' => $inputClasses->add('radio-secondary'),
            'accent' => $inputClasses->add('radio-accent'),
            'success' => $inputClasses->add('radio-success'),
            'warning' => $inputClasses->add('radio-warning'),
            'error', 'danger' => $inputClasses->add('radio-error'),
            'info' => $inputClasses->add('radio-info'),
            default => $inputClasses->add('radio-neutral'),
        };

        match ($state) {
            'valid' => $inputClasses->add('radio-success'),
            'invalid' => $inputClasses->add('radio-error'),
            'loading' => $inputClasses->add('opacity-75'),
            default => null,
        };

        if (($interactState['focused'] ?? false) === true) {
            $inputClasses->add('ring');
        }

        if (($interactState['pressed'] ?? false) === true) {
            $inputClasses->add('scale-95');
        }

        if (! empty($context['attributes']['class'])) {
            $inputClasses->merge((string) $context['attributes']['class']);
        }

        return [
            'root' => 'form-control',
            'label' => 'label cursor-pointer justify-start gap-3',
            'input' => $inputClasses->toString(),
            'text' => 'label-text',
            'helper' => 'label-text-alt',
            'error' => 'label-text-alt text-error',
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