<?php

namespace W4\UI\Framework\Support\Traits;

use W4\UI\Framework\Support\ComponentId;

trait InteractsWithIdentity
{
    protected ?string $id = null;

    protected ?string $name = null;

    public function id(?string $id = null): string|static
    {
        if ($id === null) {
            return $this->id ??= $this->generateId();
        }

        $this->id = $id;

        return $this;
    }

    public function name(?string $name = null): string|static|null
    {
        if ($name === null) {
            return $this->name;
        }

        $this->name = $name;

        return $this;
    }

    public function hasName(): bool
    {
        return $this->name !== null && $this->name !== '';
    }

    protected function generateId(): string
    {
        if ($this->hasName()) {
            return ComponentId::fromName($this->componentName(), $this->name);
        }

        return ComponentId::generate($this->componentName());
    }
}
