<?php

namespace W4\UiFramework\Core;

use InvalidArgumentException;
use W4\UiFramework\Contracts\ComponentInterface;

class ComponentRegistry
{
    /**
     * @var array<string, class-string<ComponentInterface>>
     */
    protected array $components = [];

    public function register(string $alias, string $class): static
    {
        if (! class_exists($class)) {
            throw new InvalidArgumentException("La clase de componente [{$class}] no existe.");
        }

        if (! is_subclass_of($class, ComponentInterface::class)) {
            throw new InvalidArgumentException(
                "La clase de componente [{$class}] debe implementar " . ComponentInterface::class . '.'
            );
        }

        $this->components[$alias] = $class;

        return $this;
    }

    public function has(string $alias): bool
    {
        return array_key_exists($alias, $this->components);
    }

    public function get(string $alias): ?string
    {
        return $this->components[$alias] ?? null;
    }

    public function all(): array
    {
        return $this->components;
    }

    public function forget(string $alias): static
    {
        unset($this->components[$alias]);

        return $this;
    }

    public function flush(): static
    {
        $this->components = [];

        return $this;
    }
}
