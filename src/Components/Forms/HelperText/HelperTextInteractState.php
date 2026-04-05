<?php

namespace W4\UiFramework\Components\Forms\HelperText;

class HelperTextInteractState
{
    public function __construct(
        public bool $focused = false,
        public bool $hovered = false,
    ) {}

    public function toArray(): array
    {
        return [
            'focused' => $this->focused,
            'hovered' => $this->hovered,
        ];
    }
}
