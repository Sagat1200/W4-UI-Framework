<?php

namespace W4\UiFramework\Themes\DaisyUI\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class CheckBoxThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';
        $interactState = $context['interact_state'] ?? [];

        $inputClasses = ClassBag::make(['checkbox']);

        match ($size) {
            'xs' => $inputClasses->add('checkbox-xs'),
            'sm' => $inputClasses->add('checkbox-sm'),
            'md' => $inputClasses->add('checkbox-md'),
            'lg' => $inputClasses->add('checkbox-lg'),
            'xl' => $inputClasses->add('checkbox-lg'),
            default => null,
        };

        match ($variant) {
            'neutral', 'default' => $inputClasses->add('checkbox-neutral'),
            'primary' => $inputClasses->add('checkbox-primary'),
            'secondary' => $inputClasses->add('checkbox-secondary'),
            'accent' => $inputClasses->add('checkbox-accent'),
            'success' => $inputClasses->add('checkbox-success'),
            'warning' => $inputClasses->add('checkbox-warning'),
            'error', 'danger' => $inputClasses->add('checkbox-error'),
            'info' => $inputClasses->add('checkbox-info'),
            default => $inputClasses->add('checkbox-neutral'),
        };

        match ($state) {
            'valid' => $inputClasses->add('checkbox-success'),
            'invalid' => $inputClasses->add('checkbox-error'),
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
        $checked = (bool) ($context['checked'] ?? false);
        $indeterminate = (bool) ($context['indeterminate'] ?? false);

        return array_merge($userAttributes, [
            'type' => 'checkbox',
            'name' => $context['name'] ?? $userAttributes['name'] ?? null,
            'id' => $context['id'] ?? $userAttributes['id'] ?? null,
            'value' => $context['value'] ?? $userAttributes['value'] ?? null,
            'checked' => $indeterminate ? false : $checked,
            'disabled' => in_array($state, ['disabled', 'loading'], true),
            'readonly' => $state === 'readonly',
            'aria-invalid' => $state === 'invalid' ? 'true' : 'false',
            'aria-busy' => $state === 'loading' ? 'true' : 'false',
            'aria-checked' => $indeterminate ? 'mixed' : ($checked ? 'true' : 'false'),
            'data-indeterminate' => $indeterminate ? 'true' : 'false',
            'data-focused' => ($interactState['focused'] ?? false) ? 'true' : 'false',
            'data-hovered' => ($interactState['hovered'] ?? false) ? 'true' : 'false',
            'data-pressed' => ($interactState['pressed'] ?? false) ? 'true' : 'false',
        ]);
    }
}