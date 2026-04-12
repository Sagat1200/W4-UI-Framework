<?php

namespace W4\UI\Framework\Components\FeedBack\Badge;

enum BadgeComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case HIGHLIGHTED = 'highlighted';
}
