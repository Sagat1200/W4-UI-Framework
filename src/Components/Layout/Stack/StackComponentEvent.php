<?php

namespace W4\UiFramework\Components\Layout\Stack;

enum StackComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case SET_HORIZONTAL = 'set_horizontal';
    case SET_VERTICAL = 'set_vertical';
    case SET_WRAP = 'set_wrap';
    case SET_NOWRAP = 'set_nowrap';
    case RESET = 'reset';
}
