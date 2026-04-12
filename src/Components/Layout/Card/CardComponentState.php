<?php

namespace W4\UI\Framework\Components\Layout\Card;

enum CardComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case COLLAPSED = 'collapsed';
}
