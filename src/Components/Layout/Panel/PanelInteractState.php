<?php

namespace W4\UI\Framework\Components\Layout\Panel;

class PanelInteractState
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
