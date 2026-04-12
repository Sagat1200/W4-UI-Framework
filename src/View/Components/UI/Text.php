<?php

namespace W4\UI\Framework\View\Components\UI;

use W4\UI\Framework\Components\UI\Text\Text as TextComponent;
use W4\UI\Framework\Components\UI\Text\TextComponentEvent;
use W4\UI\Framework\Components\UI\Text\TextInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Text extends BaseW4BladeComponent
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
        $text = TextComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size);

        if ($this->text !== null) {
            $text->text($this->text);
        }

        if ($this->hidden) {
            $text->dispatch(TextComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $text->dispatch(TextComponentEvent::DISABLE);
        } elseif ($this->active) {
            $text->dispatch(TextComponentEvent::ACTIVATE);
        }

        $text->interactState(new TextInteractState(
            hovered: $this->hovered,
            focused: $this->focused,
        ));

        return $text;
    }
}
