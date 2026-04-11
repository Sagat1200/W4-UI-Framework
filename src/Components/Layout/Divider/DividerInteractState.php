<?php

namespace W4\UiFramework\Components\Layout\Divider;

class DividerInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
        ];
    }
}
