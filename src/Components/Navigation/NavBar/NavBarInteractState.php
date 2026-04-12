<?php

namespace W4\UI\Framework\Components\Navigation\NavBar;

class NavBarInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $mobileExpanded = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'mobile_expanded' => $this->mobileExpanded,
        ];
    }
}
