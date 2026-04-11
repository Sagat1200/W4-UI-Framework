<?php

namespace W4\UiFramework\Components\Navigation\BreadCrumb;

class BreadCrumbInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $collapsed = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'collapsed' => $this->collapsed,
        ];
    }
}
