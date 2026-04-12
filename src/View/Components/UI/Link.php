<?php

namespace W4\UI\Framework\View\Components\UI;

use W4\UI\Framework\Components\UI\Link\Link as LinkComponent;
use W4\UI\Framework\Components\UI\Link\LinkComponentEvent;
use W4\UI\Framework\Components\UI\Link\LinkInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Link extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $text = null,
        public ?string $href = null,
        public ?string $target = null,
        public ?string $rel = null,
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
        $link = LinkComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size);

        if ($this->text !== null) {
            $link->text($this->text);
        }

        if ($this->href !== null) {
            $link->href($this->href);
        }

        if ($this->target !== null) {
            $link->target($this->target);
        }

        if ($this->rel !== null) {
            $link->rel($this->rel);
        }

        if ($this->hidden) {
            $link->dispatch(LinkComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $link->dispatch(LinkComponentEvent::DISABLE);
        } elseif ($this->active) {
            $link->dispatch(LinkComponentEvent::ACTIVATE);
        }

        $link->interactState(new LinkInteractState(
            hovered: $this->hovered,
            focused: $this->focused,
        ));

        return $link;
    }
}
