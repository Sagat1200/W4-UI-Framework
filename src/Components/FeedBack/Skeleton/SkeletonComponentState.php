<?php

namespace W4\UI\Framework\Components\FeedBack\Skeleton;

enum SkeletonComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case LOADING = 'loading';
}
