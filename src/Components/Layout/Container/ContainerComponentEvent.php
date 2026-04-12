<?php

namespace W4\UI\Framework\Components\Layout\Container;

enum ContainerComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case SET_FLUID = 'set_fluid';
    case SET_FIXED = 'set_fixed';
    case RESET = 'reset';
}
