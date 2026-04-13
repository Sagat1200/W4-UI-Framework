<?php

namespace W4\UI\Framework\Components\FeedBack\Progress;

enum ProgressComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case LOADING = 'loading';
    case INDETERMINATE = 'indeterminate';
}
