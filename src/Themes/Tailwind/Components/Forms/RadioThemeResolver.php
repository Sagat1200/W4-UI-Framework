<?php

namespace W4\UiFramework\Themes\Tailwind\Components\Forms;

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

        $inputClasses = ClassBag::make([
            'rounded-full',
            'border',
            'transition',
            'focus:outline-none',
            'focus:ring-2',
            'disabled:opacity-50',
            'disabled:cursor-not-allowed',
        ]);

        $inputClasses->add(match ($variant) {
            'neutral', 'default' => 'border-slate-300 text-slate-700 focus:ring-slate-400',
            'primary' => 'border-blue-400 text-blue-600 focus:ring-blue-500',
            'secondary' => 'border-slate-400 text-slate-600 focus:ring-slate-500',
            'accent' => 'border-violet-400 text-violet-600 focus:ring-violet-500',
            'success' => 'border-emerald-400 text-emerald-600 focus:ring-emerald-500',
            'warning' => 'border-amber-400 text-amber-600 focus:ring-amber-500',
            'error', 'danger' => 'border-rose-400 text-rose-600 focus:ring-rose-500',
            'info' => 'border-cyan-400 text-cyan-600 focus:ring-cyan-500',
            default => 'border-slate-300 text-slate-700 focus:ring-slate-400',
        });

        $sizeClasses = [
            'xs' => 'h-3 w-3',
            'sm' => 'h-4 w-4',
            'md' => 'h-5 w-5',
            'lg' => 'h-6 w-6',
            'xl' => 'h-7 w-7',
        ];

        $inputClasses->add($sizeClasses[$size] ?? $sizeClasses['md']);

        match ($state) {
            'valid' => $inputClasses->add('border-emerald-500 text-emerald-600'),
            'invalid' => $inputClasses->add('border-rose-500 text-rose-600'),
            'loading' => $inputClasses->add('opacity-75 animate-pulse'),
            default => null,
        };

        if (($interactState['focused'] ?? false) === true) {
            $inputClasses->add('ring-2');
        }

        if (($interactState['pressed'] ?? false) === true) {
            $inputClasses->add('scale-95');
        }

        if (! empty($context['attributes']['class'])) {
            $inputClasses->merge((string) $context['attributes']['class']);
        }

        return [
            'root' => 'flex flex-col gap-1',
            'label' => 'inline-flex items-center gap-2',
            'input' => $inputClasses->toString(),
            'text' => 'text-sm font-medium text-slate-700',
            'helper' => 'text-sm text-slate-500',
            'error' => 'text-sm text-rose-600',
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