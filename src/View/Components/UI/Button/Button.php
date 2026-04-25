<?php

namespace W4\UI\Framework\View\Components\UI\Button;

use W4\UI\Framework\Components\UI\Button\Button as ButtonComponent;
use W4\UI\Framework\Components\UI\Button\ButtonComponentEvent;
use W4\UI\Framework\Components\UI\Button\ButtonInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Button extends BaseW4BladeComponent
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
        $button = ButtonComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size);

        if ($this->icon) {
            $button->icon($this->icon);
        }

        if ($this->type) {
            $button->attribute('type', $this->type);
        }

        if ($this->loading) {
            $button->dispatch(ButtonComponentEvent::START_LOADING);
        } elseif ($this->disabled) {
            $button->dispatch(ButtonComponentEvent::DISABLE);
        } elseif ($this->readonly) {
            $button->dispatch(ButtonComponentEvent::SET_READONLY);
        } elseif ($this->active) {
            $button->dispatch(ButtonComponentEvent::SET_ACTIVE);
        }

        $button->interactState(new ButtonInteractState());

        return $button;
    }
}