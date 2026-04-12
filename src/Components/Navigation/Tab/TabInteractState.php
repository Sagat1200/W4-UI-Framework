<?php

namespace W4\UI\Framework\Components\Navigation\Tab;

class TabInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $selected = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'selected' => $this->selected,
        ];
    }
}
