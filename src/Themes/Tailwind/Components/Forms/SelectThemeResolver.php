<?php

namespace W4\UiFramework\Themes\Tailwind\Components\Forms;

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

        $inputClasses = ClassBag::make([
            'block',
            'w-full',
            'rounded-md',
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
            'xs' => 'px-2 py-1 text-xs',
            'sm' => 'px-2.5 py-1.5 text-sm',
            'md' => 'px-3 py-2 text-base',
            'lg' => 'px-3.5 py-2.5 text-lg',
            'xl' => 'px-4 py-3 text-xl',
        ];

        $inputClasses->add($sizeClasses[$size] ?? $sizeClasses['md']);

        match ($state) {
            'valid' => $inputClasses->add('border-emerald-500 text-emerald-600'),
            'invalid' => $inputClasses->add('border-rose-500 text-rose-600'),
            'loading' => $inputClasses->add('opacity-75 animate-pulse'),
            default => null,
        };

        if (($interactState['focused'] ?? false) === true || ($interactState['opened'] ?? false) === true) {
            $inputClasses->add('ring-2');
        }

        if (! empty($context['attributes']['class'])) {
            $userClasses = (string) $context['attributes']['class'];

            if (preg_match('/(?:^|\s)!?(?:[a-z0-9-]+:)*w-(?:\S+)/i', $userClasses) === 1) {
                $inputClasses->remove('w-full');
            }

            if (preg_match('/(?:^|\s)!?(?:[a-z0-9-]+:)*(?:h|min-h|max-h)-(?:\S+)/i', $userClasses) === 1) {
                $inputClasses
                    ->remove('px-2 py-1 text-xs')
                    ->remove('px-2.5 py-1.5 text-sm')
                    ->remove('px-3 py-2 text-base')
                    ->remove('px-3.5 py-2.5 text-lg')
                    ->remove('px-4 py-3 text-xl');
            }

            $inputClasses->merge($userClasses);
        }

        return [
            'root' => 'flex flex-col gap-1 w-full',
            'input' => $inputClasses->toString(),
            'helper' => 'text-sm text-slate-500',
            'error' => 'text-sm text-rose-600',
            'label' => 'text-sm font-medium text-slate-700',
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
