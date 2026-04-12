<?php

namespace W4\UI\Framework\Components\Forms\FielError;

class FieldErrorInteractState
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
