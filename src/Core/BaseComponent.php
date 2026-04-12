<?php

namespace W4\UI\Framework\Core;

use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\Support\Traits\InteractsWithAttributes;
use W4\UI\Framework\Support\Traits\InteractsWithIdentity;
use W4\UI\Framework\Support\Traits\InteractsWithLabel;
use W4\UI\Framework\Support\Traits\InteractsWithMetadata;
use W4\UI\Framework\Support\Traits\InteractsWithTheme;

abstract class BaseComponent implements ComponentInterface
{
    use InteractsWithAttributes;
    use InteractsWithIdentity;
    use InteractsWithLabel;
    use InteractsWithMetadata;
    use InteractsWithTheme;

    public function __construct()
    {
        $this->initializeInteractsWithAttributes();
        $this->initializeInteractsWithMetadata();
    }

    public static function make(?string $label = null): static
    {
        $instance = new static();

        if ($label !== null) {
            $instance->label($label);
        }

        return $instance;
    }

    abstract public function componentName(): string;

    public function toThemeContext(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'label' => $this->label(),
            'theme' => $this->theme(),
            'attributes' => $this->attributesToArray(),
            'meta' => $this->metadataToArray(),
            'component' => $this->componentName(),
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'component' => $this->componentName(),
            'name' => $this->name(),
            'label' => $this->label(),
            'theme' => $this->theme(),
            'attributes' => $this->attributesToArray(),
            'meta' => $this->metadataToArray(),
        ];
    }
}