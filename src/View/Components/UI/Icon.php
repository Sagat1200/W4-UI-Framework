<?php

namespace W4\UI\Framework\View\Components\UI;

use W4\UI\Framework\Components\UI\Icon\Icon as IconComponent;
use W4\UI\Framework\Components\UI\Icon\IconComponentEvent;
use W4\UI\Framework\Components\UI\Icon\IconInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Icon extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $icon = null,
        public bool $spin = false,
        public bool $decorative = false,
        public string $variant = 'neutral',
        public string $size = 'md',
        public bool $disabled = false,
        public bool $active = false,
        public bool $hidden = false,
        public bool $focused = false,
        public bool $hovered = false,
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
        $icon = IconComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->spin($this->spin)
            ->decorative($this->decorative);

        if ($this->icon !== null) {
            $icon->icon($this->icon);
        }

        if ($this->hidden) {
            $icon->dispatch(IconComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $icon->dispatch(IconComponentEvent::DISABLE);
        } elseif ($this->active) {
            $icon->dispatch(IconComponentEvent::ACTIVATE);
        }

        $icon->interactState(new IconInteractState(
            hovered: $this->hovered,
            focused: $this->focused,
        ));

        return $icon;
    }
}
