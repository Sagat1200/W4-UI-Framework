<?php

namespace W4\UI\Framework\Components\Navigation\Menu;

class MenuInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $opened = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'opened' => $this->opened,
        ];
    }
}
