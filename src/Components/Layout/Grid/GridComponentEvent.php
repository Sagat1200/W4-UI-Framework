<?php

namespace W4\UI\Framework\Components\Layout\Grid;

enum GridComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case SET_DENSE = 'set_dense';
    case SET_RELAXED = 'set_relaxed';
    case RESET = 'reset';
}
