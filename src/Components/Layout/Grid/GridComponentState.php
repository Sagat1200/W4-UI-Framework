<?php

namespace W4\UI\Framework\Components\Layout\Grid;

enum GridComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
