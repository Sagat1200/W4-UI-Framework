<?php

namespace W4\UI\Framework\Support;

class ClassBag
{
    protected array $classes = [];

    public function __construct(array|string|null $classes = null)
    {
        if ($classes !== null) {
            $this->add($classes);
        }
    }

    public static function make(array|string|null $classes = null): static
    {
        return new static($classes);
    }

    public function add(array|string $classes): static
    {
        $items = is_array($classes)
            ? $classes
            : (preg_split('/\\s+/', trim($classes)) ?: []);

        foreach ($items as $class) {
            $class = trim((string) $class);

            if ($class === '') {
                continue;
            }

            if (! in_array($class, $this->classes, true)) {
                $this->classes[] = $class;
            }
        }

        return $this;
    }

    public function merge(array|string|null $classes): static
    {
        if ($classes === null) {
            return $this;
        }

        return $this->add($classes);
    }

    public function remove(string $class): static
    {
        $this->classes = array_values(
            array_filter(
                $this->classes,
                fn(string $item) => $item !== $class
            )
        );

        return $this;
    }

    public function has(string $class): bool
    {
        return in_array($class, $this->classes, true);
    }

    public function all(): array
    {
        return $this->classes;
    }

    public function toArray(): array
    {
        return $this->all();
    }

    public function toString(): string
    {
        return implode(' ', $this->classes);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
