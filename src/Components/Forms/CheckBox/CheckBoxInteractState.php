<?php

namespace W4\UI\Framework\Components\Forms\CheckBox;

class CheckBoxInteractState
{
    public function __construct(
        public bool $focused = false,
        public bool $hovered = false,
        public bool $pressed = false,
    ) {}

    public function toArray(): array
    {
        return [
            'focused' => $this->focused,
            'hovered' => $this->hovered,
            'pressed' => $this->pressed,
        ];
    }
}
