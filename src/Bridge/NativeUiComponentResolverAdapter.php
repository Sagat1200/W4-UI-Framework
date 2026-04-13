<?php

namespace W4\UI\Framework\Bridge;

use W4\UI\Framework\Contracts\ComponentThemeResolverInterface;

class NativeUiComponentResolverAdapter implements ComponentThemeResolverInterface
{
    public function __construct(
        protected object $nativeTheme,
        protected string $component
    ) {}

    public function classes(array $context = []): array
    {
        $contract = $this->resolveNativeContract($context);
        $primary = $this->classesToString($contract['classes'] ?? []);
        $userClass = is_string($context['attributes']['class'] ?? null)
            ? trim((string) $context['attributes']['class'])
            : '';

        $slots = $this->slotMapFor($this->component);
        $resolved = [];

        foreach ($slots as $slot => $source) {
            if ($source === 'primary') {
                $resolved[$slot] = $this->joinClasses([$primary, $userClass]);
                continue;
            }

            $resolved[$slot] = $source;
        }

        if ($resolved === []) {
            $resolved['root'] = $this->joinClasses([$primary, $userClass]);
        }

        return $resolved;
    }

    public function attributes(array $context = []): array
    {
        $contract = $this->resolveNativeContract($context);
        $states = $this->extractActiveStates($context);
        $jsHooks = $contract['js_hooks'] ?? [];

        return array_filter([
            'data-w4-component' => $this->normalizeComponent($this->component),
            'data-w4-state' => $states === [] ? null : implode(' ', $states),
            'data-w4-hook' => is_array($jsHooks) && $jsHooks !== [] ? implode(' ', $jsHooks) : null,
        ], fn($value) => $value !== null && $value !== '');
    }

    protected function resolveNativeContract(array $context): array
    {
        $component = $this->normalizeComponent($this->component);
        $state = $this->buildNativeState($context);

        if (! method_exists($this->nativeTheme, 'resolveComponentContract')) {
            return [
                'classes' => ['w4-' . $component],
                'state_map' => [],
                'js_hooks' => [],
            ];
        }

        /** @var mixed $resolved */
        $resolved = $this->nativeTheme->resolveComponentContract($component, $state);

        return is_array($resolved) ? $resolved : [
            'classes' => ['w4-' . $component],
            'state_map' => [],
            'js_hooks' => [],
        ];
    }

    protected function buildNativeState(array $context): array
    {
        $state = [];

        foreach (['variant', 'size', 'state'] as $key) {
            if (isset($context[$key]) && is_scalar($context[$key])) {
                $state[$key] = (string) $context[$key];
            }
        }

        $states = $this->extractActiveStates($context);
        if ($states !== []) {
            $state['states'] = $states;
        }

        return $state;
    }

    protected function extractActiveStates(array $context): array
    {
        $states = [];

        if (isset($context['state']) && is_scalar($context['state'])) {
            $states[] = (string) $context['state'];
        }

        foreach (['interact_state', 'accessibility_state'] as $bagKey) {
            $bag = $context[$bagKey] ?? null;
            if (! is_array($bag)) {
                continue;
            }

            foreach ($bag as $key => $value) {
                if ($value === true) {
                    $states[] = (string) $key;
                }
            }
        }

        $states = array_values(array_unique(array_filter(
            array_map(fn($state) => strtolower(trim((string) $state)), $states),
            fn($state) => $state !== ''
        )));

        return $states;
    }

    protected function slotMapFor(string $component): array
    {
        $normalized = $this->normalizeComponent($component);

        return match ($normalized) {
            'input', 'select', 'textarea' => [
                'root' => '',
                'input' => 'primary',
                'label' => 'w4-label',
                'helper' => 'w4-helper-text',
                'error' => 'w4-field-error',
            ],
            'checkbox', 'radio', 'toggle' => [
                'root' => '',
                'input' => 'primary',
                'label' => 'w4-label',
                'text' => 'w4-text',
                'helper' => 'w4-helper-text',
                'error' => 'w4-field-error',
            ],
            'helper-text' => [
                'root' => 'primary',
                'icon' => 'primary',
                'text' => 'primary',
            ],
            'field-error' => [
                'root' => 'primary',
                'code' => 'primary',
                'hint' => 'primary',
            ],
            'tooltip' => [
                'root' => 'primary',
                'bubble' => 'primary',
            ],
            default => [
                'root' => 'primary',
            ],
        };
    }

    protected function normalizeComponent(string $component): string
    {
        return strtolower(trim($component));
    }

    protected function classesToString(array|string $classes): string
    {
        if (is_string($classes)) {
            return trim($classes);
        }

        $filtered = array_filter(
            array_map(fn($value) => trim((string) $value), $classes),
            fn($value) => $value !== ''
        );

        return implode(' ', array_values(array_unique($filtered)));
    }

    protected function joinClasses(array $classes): string
    {
        $filtered = array_filter(
            array_map(fn($value) => trim((string) $value), $classes),
            fn($value) => $value !== ''
        );

        return implode(' ', array_values(array_unique($filtered)));
    }
}
