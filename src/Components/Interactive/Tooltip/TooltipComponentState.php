<?php

namespace W4\UiFramework\Components\Interactive\Tooltip;

enum TooltipComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case OPEN = 'open';
}