<?php

namespace W4\UI\Framework\Components\Navigation\Menu;

enum MenuComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case OPEN = 'open';
    case CLOSE = 'close';
    case TOGGLE = 'toggle';
    case RESET = 'reset';
}
