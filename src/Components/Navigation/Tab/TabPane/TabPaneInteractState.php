<?php

namespace W4\UI\Framework\Components\Navigation\Tab\TabPane;

class TabPaneInteractState
{
    public function __construct(
        public bool $active = false,
    ) {}

    public function toArray(): array
    {
        return [
            'active' => $this->active,
        ];
    }
}
