<?php

namespace W4\UiFramework\Components\Layout\Card;

class CardInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $expanded = true,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'expanded' => $this->expanded,
        ];
    }
}
