<?php

namespace W4\UI\Framework\Components\Layout\Divider;

enum DividerComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
