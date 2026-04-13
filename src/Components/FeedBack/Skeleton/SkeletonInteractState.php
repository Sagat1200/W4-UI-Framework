<?php

namespace W4\UI\Framework\Components\FeedBack\Skeleton;

class SkeletonInteractState
{
    public function __construct(
        public bool $hovered = false,
        public bool $focused = false,
        public bool $loading = false,
        public bool $animated = true,
    ) {}

    public function toArray(): array
    {
        return [
            'hovered' => $this->hovered,
            'focused' => $this->focused,
            'loading' => $this->loading,
            'animated' => $this->animated,
        ];
    }
}
