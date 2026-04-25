<?php

namespace W4\UI\Framework\Components\Navigation\Drawer;

enum DrawerComponentEvent: string
{
    case OPEN = 'open';
    case CLOSE = 'close';
    case TOGGLE = 'toggle';
}
