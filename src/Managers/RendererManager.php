<?php

namespace W4\UiFramework\Managers;

use InvalidArgumentException;
use W4\UiFramework\Contracts\RendererInterface;

class RendererManager
{
    /**
     * @var array<string, RendererInterface>
     */
    protected array $renderers = [];

    public function register(string $key, RendererInterface $renderer): static
    {
        $this->renderers[$key] = $renderer;

        return $this;
    }

    public function driver(string $key): RendererInterface
    {
        if (! isset($this->renderers[$key])) {
            throw new InvalidArgumentException("El renderizador [{$key}] no está registrado.");
        }

        return $this->renderers[$key];
    }

    public function all(): array
    {
        return $this->renderers;
    }
}
