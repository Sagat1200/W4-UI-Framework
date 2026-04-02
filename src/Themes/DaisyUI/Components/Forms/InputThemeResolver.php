<?php

namespace W4\UiFramework\Themes\DaisyUI\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class InputThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';
        $interactState = $context['interact_state'] ?? [];

        $inputClasses = ClassBag::make(['input', 'input-bordered', 'w-full']);

        match ($size) {
            'xs' => $inputClasses->add('input-xs'),
            'sm' => $inputClasses->add('input-sm'),
            'md' => $inputClasses->add('input-md'),
            'lg' => $inputClasses->add('input-lg'),
            'xl' => $inputClasses->add('input-xl'),
            default => null,
        };

        match ($variant) {
            'neutral' => $inputClasses->add('input-neutral'),
            'primary' => $inputClasses->add('input-primary'),
            'secondary' => $inputClasses->add('input-secondary'),
            'accent' => $inputClasses->add('input-accent'),
            'success' => $inputClasses->add('input-success'),
            'warning' => $inputClasses->add('input-warning'),
            'error' => $inputClasses->add('input-error'),
            default => $inputClasses->add('input-neutral'),
        };

        match ($state) {
            'valid' => $inputClasses->add('input-success'),
            'invalid' => $inputClasses->add('input-error'),
            'loading' => $inputClasses->add('opacity-75'),
            default => null,
        };

        if (($interactState['focused'] ?? false) === true) {
            $inputClasses->add('ring');
        }

        if (! empty($context['attributes']['class'])) {
            $inputClasses->merge($context['attributes']['class']);
        }

        return [
            'root' => 'form-control w-full',
            'input' => $inputClasses->toString(),
            'helper' => 'label-text-alt',
            'error' => 'label-text-alt text-error',
            'label' => 'label-text',
        ];
    }

    public function attributes(array $context = []): array
    {
        $state = $context['state'] ?? 'enabled';
        $userAttributes = $context['attributes'] ?? [];
        $interactState = $context['interact_state'] ?? [];

        return array_merge($userAttributes, [
            'type' => $context['type'] ?? $userAttributes['type'] ?? 'text',
            'name' => $context['name'] ?? $userAttributes['name'] ?? null,
            'id' => $context['id'] ?? $userAttributes['id'] ?? null,
            'value' => $context['value'] ?? $userAttributes['value'] ?? null,
            'placeholder' => $context['placeholder'] ?? $userAttributes['placeholder'] ?? null,
            'disabled' => in_array($state, ['disabled', 'loading'], true),
            'readonly' => $state === 'readonly',
            'aria-invalid' => in_array($state, ['invalid'], true) ? 'true' : 'false',
            'aria-busy' => $state === 'loading' ? 'true' : 'false',
            'data-focused' => ($interactState['focused'] ?? false) ? 'true' : 'false',
            'data-hovered' => ($interactState['hovered'] ?? false) ? 'true' : 'false',
            'data-filled' => ($interactState['filled'] ?? false) ? 'true' : 'false',
        ]);
    }
}
