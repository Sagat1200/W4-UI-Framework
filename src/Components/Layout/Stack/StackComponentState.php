<?php

namespace W4\UI\Framework\Components\Layout\Stack;

enum StackComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
