<?php

namespace W4\UiFramework\Themes\DaisyUI\Components\Forms;

use W4\UiFramework\Contracts\ComponentThemeResolverInterface;
use W4\UiFramework\Support\ClassBag;

class SelectThemeResolver implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $variant = $context['variant'] ?? 'neutral';
        $size = $context['size'] ?? 'md';
        $state = $context['state'] ?? 'enabled';
        $interactState = $context['interact_state'] ?? [];

        $inputClasses = ClassBag::make(['select', 'select-bordered', 'w-full']);

        match ($size) {
            'xs' => $inputClasses->add('select-xs'),
            'sm' => $inputClasses->add('select-sm'),
            'md' => $inputClasses->add('select-md'),
            'lg' => $inputClasses->add('select-lg'),
            'xl' => $inputClasses->add('select-lg'),
            default => null,
        };

        match ($variant) {
            'neutral', 'default' => $inputClasses->add('select-neutral'),
            'primary' => $inputClasses->add('select-primary'),
            'secondary' => $inputClasses->add('select-secondary'),
            'accent' => $inputClasses->add('select-accent'),
            'success' => $inputClasses->add('select-success'),
            'warning' => $inputClasses->add('select-warning'),
            'error', 'danger' => $inputClasses->add('select-error'),
            'info' => $inputClasses->add('select-info'),
            default => $inputClasses->add('select-neutral'),
        };

        match ($state) {
            'valid' => $inputClasses->add('select-success'),
            'invalid' => $inputClasses->add('select-error'),
            'loading' => $inputClasses->add('opacity-75'),
            default => null,
        };

        if (($interactState['focused'] ?? false) === true || ($interactState['opened'] ?? false) === true) {
            $inputClasses->add('ring');
        }

        if (! empty($context['attributes']['class'])) {
            $userClasses = (string) $context['attributes']['class'];

            if (preg_match('/(?:^|\s)!?(?:[a-z0-9-]+:)*w-(?:\S+)/i', $userClasses) === 1) {
                $inputClasses->remove('w-full');
            }

            if (preg_match('/(?:^|\s)!?(?:[a-z0-9-]+:)*(?:h|min-h|max-h)-(?:\S+)/i', $userClasses) === 1) {
                $inputClasses
                    ->remove('select-xs')
                    ->remove('select-sm')
                    ->remove('select-md')
                    ->remove('select-lg');
            }

            $inputClasses->merge($userClasses);
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