<?php

namespace W4\UI\Framework\Components\Navigation\Drawer;

class DrawerInteractState
{
    public function __construct(
        public bool $open = false,
        public string $position = 'right',
        public bool $overlay = true,
    ) {}

    public function toArray(): array
    {
        return [
            'open' => $this->open,
            'position' => $this->position,
            'overlay' => $this->overlay,
        ];
    }
}
