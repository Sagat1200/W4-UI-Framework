<?php

namespace W4\UI\Framework\Components\Layout\Container;

enum ContainerComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
