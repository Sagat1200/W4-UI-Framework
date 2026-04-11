<?php

namespace W4\UiFramework\Components\Interactive\Tooltip;

enum TooltipComponentEvent: string
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
