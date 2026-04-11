<?php

namespace W4\UiFramework\Components\FeedBack\Badge;

class BadgeInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $highlighted = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'highlighted' => $this->highlighted,
        ];
    }
}
