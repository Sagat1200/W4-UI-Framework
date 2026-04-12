<?php

namespace W4\UI\Framework\Components\FeedBack\Alert;

class AlertInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $dismissed = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'dismissed' => $this->dismissed,
        ];
    }
}
