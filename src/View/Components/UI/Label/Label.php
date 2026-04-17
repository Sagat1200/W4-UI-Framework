<?php

namespace W4\UI\Framework\View\Components\UI\Label;

use W4\UI\Framework\Components\UI\Label\Label as LabelComponent;
use W4\UI\Framework\Components\UI\Label\LabelComponentEvent;
use W4\UI\Framework\Components\UI\Label\LabelInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Label extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $text = null,
        public ?string $for = null,
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
        $label = LabelComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size);

        if ($this->text !== null) {
            $label->text($this->text);
        }

        if ($this->for !== null) {
            $label->for($this->for);
        }

        if ($this->hidden) {
            $label->dispatch(LabelComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $label->dispatch(LabelComponentEvent::DISABLE);
        } elseif ($this->active) {
            $label->dispatch(LabelComponentEvent::ACTIVATE);
        }

        $label->interactState(new LabelInteractState(
            hovered: $this->hovered,
            focused: $this->focused,
        ));

        return $label;
    }
}
