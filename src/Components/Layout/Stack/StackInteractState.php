<?php

namespace W4\UiFramework\Components\Layout\Stack;

class StackInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $wrapped = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'wrapped' => $this->wrapped,
        ];
    }
}
