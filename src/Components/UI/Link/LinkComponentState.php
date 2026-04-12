<?php

namespace W4\UI\Framework\Components\UI\Link;

enum LinkComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
