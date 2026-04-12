<?php

namespace W4\UI\Framework\Components\UI\Button;

class ButtonInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $pressed = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'pressed' => $this->pressed,
        ];
    }
}
