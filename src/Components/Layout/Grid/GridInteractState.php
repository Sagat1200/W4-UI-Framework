<?php

namespace W4\UiFramework\Components\Layout\Grid;

class GridInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $dense = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'dense' => $this->dense,
        ];
    }
}
