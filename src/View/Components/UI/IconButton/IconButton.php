<?php

namespace W4\UI\Framework\View\Components\UI\IconButton;

use W4\UI\Framework\Components\UI\IconButton\IconButton as IconButtonComponent;
use W4\UI\Framework\Components\UI\IconButton\IconButtonComponentEvent;
use W4\UI\Framework\Components\UI\IconButton\IconButtonInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class IconButton extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public string $variant = 'primary',
        public string $size = 'md',
        public ?string $type = 'button',
        public ?string $icon = null,
        public bool $disabled = false,
        public bool $loading = false,
        public bool $readonly = false,
        public bool $active = false,
        public bool $focused = false,
        public bool $hovered = false,
        public bool $pressed = false,
    ) {
        parent::__construct(
            id: $id,
            name: $name,
            theme: $theme,
            renderer: $renderer,
            componentId: $componentId,
        );
    }

    protected function makeComponent(): ComponentInterface
    {
        $iconButton = IconButtonComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size);

        if ($this->icon !== null) {
            $iconButton->icon($this->icon);
        }

        if ($this->type) {
            $iconButton->attribute('type', $this->type);
        }

        if ($this->loading) {
            $iconButton->dispatch(IconButtonComponentEvent::START_LOADING);
        } elseif ($this->disabled) {
            $iconButton->dispatch(IconButtonComponentEvent::DISABLE);
        } elseif ($this->readonly) {
            $iconButton->dispatch(IconButtonComponentEvent::SET_READONLY);
        } elseif ($this->active) {
            $iconButton->dispatch(IconButtonComponentEvent::SET_ACTIVE);
        }

        $iconButton->interactState(new IconButtonInteractState(
            hovered: $this->hovered,
            focused: $this->focused,
            pressed: $this->pressed,
        ));

        return $iconButton;
    }
}
