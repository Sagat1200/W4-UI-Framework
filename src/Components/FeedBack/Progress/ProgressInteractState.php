<?php

namespace W4\UI\Framework\Components\FeedBack\Progress;

class ProgressInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $loading = false,
        public bool $indeterminate = false,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'loading' => $this->loading,
            'indeterminate' => $this->indeterminate,
        ];
    }
}
