<?php

namespace W4\UI\Framework\Themes\NativeUI\UI\Button;

use W4\UI\Framework\Contracts\ComponentThemeResolverInterface;

class ButtonTheme implements ComponentThemeResolverInterface
{
    public function classes(array $context = []): array
    {
        $classes = ['w4-button'];

        $variant = trim((string) ($context['variant'] ?? ''));
        if ($variant !== '') {
            $classes[] = 'w4-button-' . $variant;
        }

        $size = trim((string) ($context['size'] ?? ''));
        if ($size !== '') {
            $classes[] = 'w4-button-' . $size;
        }

        $state = trim((string) ($context['state'] ?? ''));
        if ($state !== '' && $state !== 'enabled') {
            $classes[] = 'w4-button-' . $state;
        }

        $userClass = trim((string) (($context['attributes']['class'] ?? null) ?: ''));
        if ($userClass !== '') {
            $classes = array_merge($classes, preg_split('/\s+/', $userClass) ?: []);
        }

        $classes = array_values(array_unique(array_filter($classes, fn($value) => is_string($value) && $value !== '')));

        return [
            'root' => implode(' ', $classes),
        ];
    }

    public function attributes(array $context = []): array
    {
        $states = $this->collectStates($context);

        return array_filter([
            'data-w4-component' => 'button',
            'data-w4-state' => $states === [] ? null : implode(' ', $states),
        ], fn($value) => $value !== null && $value !== '');
    }

    protected function collectStates(array $context): array
    {
        $rawState = $context['attributes']['data-w4-state'] ?? null;

        if (is_string($rawState) && trim($rawState) !== '') {
            $states = preg_split('/\s+/', strtolower(trim($rawState))) ?: [];

            return array_values(array_unique(array_filter($states, fn($state) => $state !== '')));
        }

        $states = [];

        if (isset($context['state']) && is_scalar($context['state'])) {
            $states[] = strtolower(trim((string) $context['state']));
        }

        foreach (['interact_state', 'accessibility_state'] as $key) {
            $bag = $context[$key] ?? null;
            if (! is_array($bag)) {
                continue;
            }

            foreach ($bag as $state => $active) {
                if ($active === true) {
                    $states[] = strtolower(trim((string) $state));
                }
            }
        }

        return array_values(array_unique(array_filter($states, fn($state) => $state !== '')));
    }
}