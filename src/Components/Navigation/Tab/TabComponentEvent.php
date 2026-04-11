<?php

namespace W4\UiFramework\Components\Navigation\Tab;

enum TabComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case SELECT = 'select';
    case UNSELECT = 'unselect';
    case RESET = 'reset';
}
