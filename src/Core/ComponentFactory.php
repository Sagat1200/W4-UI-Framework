<?php

namespace W4\UiFramework\Core;

use InvalidArgumentException;
use W4\UiFramework\Contracts\ComponentInterface;

class ComponentFactory
{
    public function __construct(
        protected ComponentRegistry $registry
    ) {}

    public function make(string $component, mixed ...$arguments): ComponentInterface
    {
        $class = $this->registry->get($component);

        if ($class === null) {
            throw new InvalidArgumentException("Component [{$component}] is not registered.");
        }

        $instance = new $class(...$arguments);

        if (! $instance instanceof ComponentInterface) {
            throw new InvalidArgumentException("Registered component [{$component}] must implement ComponentInterface.");
        }

        return $instance;
    }

    public function makeFromArray(array $payload): ComponentInterface
    {
        $type = $payload['component'] ?? $payload['type'] ?? null;

        if (! is_string($type) || $type === '') {
            throw new InvalidArgumentException('Payload must contain a valid [component] or [type] key.');
        }

        $component = $this->make($type);

        if (isset($payload['id'])) {
            $component->id($payload['id']);
        }

        if (isset($payload['name']) && method_exists($component, 'name')) {
            $component->name($payload['name']);
        }

        if (isset($payload['label']) && method_exists($component, 'label')) {
            $component->label($payload['label']);
        }

        if (isset($payload['theme']) && method_exists($component, 'theme')) {
            $component->theme($payload['theme']);
        }

        if (! empty($payload['attributes']) && method_exists($component, 'attributes')) {
            $component->attributes($payload['attributes']);
        }

        if (! empty($payload['meta']) && method_exists($component, 'meta')) {
            foreach ($payload['meta'] as $key => $value) {
                $component->meta($key, $value);
            }
        }

        return $component;
    }
}
