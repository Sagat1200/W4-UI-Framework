<?php

namespace W4\UI\Framework\Core;

use InvalidArgumentException;
use W4\UI\Framework\Contracts\ComponentInterface;

class ComponentFactory
{
    public function __construct(
        protected ComponentRegistry $registry
    ) {}

    public function make(string $component, mixed ...$arguments): ComponentInterface
    {
        $class = $this->registry->get($component);

        if ($class === null) {
            throw new InvalidArgumentException("El componente [{$component}] no está registrado.");
        }

        $instance = new $class(...$arguments);

        if (! $instance instanceof ComponentInterface) {
            throw new InvalidArgumentException("El componente registrado [{$component}] debe implementar la interfaz ComponentInterface.");
        }

        return $instance;
    }

    public function makeFromArray(array $payload): ComponentInterface
    {
        $type = $payload['component'] ?? $payload['type'] ?? null;

        if (! is_string($type) || $type === '') {
            throw new InvalidArgumentException('El payload debe contener una clave válida [component] o [type].');
        }

        $component = $this->make($type);

        if (isset($payload['id']) && is_callable([$component, 'id'])) {
            call_user_func([$component, 'id'], $payload['id']);
        }

        if (isset($payload['name']) && is_callable([$component, 'name'])) {
            call_user_func([$component, 'name'], $payload['name']);
        }

        if (isset($payload['label']) && is_callable([$component, 'label'])) {
            call_user_func([$component, 'label'], $payload['label']);
        }

        if (isset($payload['theme']) && is_callable([$component, 'theme'])) {
            call_user_func([$component, 'theme'], $payload['theme']);
        }

        if (! empty($payload['attributes']) && is_callable([$component, 'attributes'])) {
            call_user_func([$component, 'attributes'], $payload['attributes']);
        }

        if (! empty($payload['meta']) && is_callable([$component, 'meta'])) {
            foreach ($payload['meta'] as $key => $value) {
                call_user_func([$component, 'meta'], $key, $value);
            }
        }

        return $component;
    }
}