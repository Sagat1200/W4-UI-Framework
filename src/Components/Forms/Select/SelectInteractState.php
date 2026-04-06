<?php

namespace W4\UiFramework\Components\Forms\Select;

class SelectInteractState
{
    public function __construct(
        public bool $focused = false,
        public bool $hovered = false,
        public bool $opened = false,
    ) {}

    public function toArray(): array
    {
        return [
            'focused' => $this->focused,
            'hovered' => $this->hovered,
            'opened' => $this->opened,
        ];
    }
}