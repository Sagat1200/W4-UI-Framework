<?php

namespace W4\UiFramework\Components\FeedBack\Loading;

class LoadingInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $loading = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'loading' => $this->loading,
        ];
    }
}
