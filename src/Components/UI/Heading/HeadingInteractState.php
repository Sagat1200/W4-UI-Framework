<?php

namespace W4\UI\Framework\Components\UI\Heading;

class HeadingInteractState
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
