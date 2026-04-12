<?php

namespace W4\UI\Framework\Components\Forms\TextArea;

class TextAreaInteractState
{
    public function __construct(
        public bool $focused = false,
        public bool $hovered = false,
        public bool $filled = false,
    ) {}

    public function toArray(): array
    {
        return [
            'focused' => $this->focused,
            'hovered' => $this->hovered,
            'filled' => $this->filled,
        ];
    }
}
