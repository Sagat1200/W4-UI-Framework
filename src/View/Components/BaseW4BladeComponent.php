<?php

namespace W4\UI\Framework\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\Support\W4UiManager;

abstract class BaseW4BladeComponent extends Component
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $theme = null,
        public ?string $renderer = null,
        public string|int|null $componentId = null,
    ) {}

    /**
     * Cada wrapper debe construir su componente del core.
     */
    abstract protected function makeComponent(): ComponentInterface;

    /**
     * Vista wrapper genérica.
     */
    public function render(): View
    {
        return view('w4-ui::components.blade.wrapper');
    }

    /**
     * Render HTML final.
     */
    public function html(): string
    {
        return app(W4UiManager::class)->render(
            $this->component(),
            $this->renderer
        );
    }

    /**
     * Devuelve el componente ya armado.
     */
    public function component(): ComponentInterface
    {
        $component = $this->makeComponent();

        if ($this->id && is_callable([$component, 'id'])) {
            call_user_func([$component, 'id'], $this->id);
        }

        if ($this->name && is_callable([$component, 'name'])) {
            call_user_func([$component, 'name'], $this->name);
        }

        if ($this->theme && is_callable([$component, 'theme'])) {
            call_user_func([$component, 'theme'], $this->theme);
        }

        if ($this->componentId !== null) {
            if (is_callable([$component, 'meta'])) {
                call_user_func([$component, 'meta'], 'component_id', $this->componentId);
            }

            if (is_callable([$component, 'attribute'])) {
                call_user_func([$component, 'attribute'], 'data-component-id', (string) $this->componentId);
            }
        }

        return $component;
    }
}
