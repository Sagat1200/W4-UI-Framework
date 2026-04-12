<?php

namespace W4\UI\Framework\View\Components\Layout;

use W4\UI\Framework\Components\Layout\Divider\Divider as DividerComponent;
use W4\UI\Framework\Components\Layout\Divider\DividerComponentEvent;
use W4\UI\Framework\Components\Layout\Divider\DividerInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Divider extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $text = null,
        public string $variant = 'neutral',
        public string $size = 'md',
        public string $orientation = 'horizontal',
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
        $divider = DividerComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->orientation($this->orientation);

        if ($this->text !== null) {
            $divider->text($this->text);
        }

        if ($this->hidden) {
            $divider->dispatch(DividerComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $divider->dispatch(DividerComponentEvent::DISABLE);
        } elseif ($this->active) {
            $divider->dispatch(DividerComponentEvent::ACTIVATE);
        }

        $divider->interactState(new DividerInteractState(
            hovered: $this->hovered,
            focused: $this->focused,
        ));

        return $divider;
    }
}
