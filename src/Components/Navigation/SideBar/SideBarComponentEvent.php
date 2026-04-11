<?php

namespace W4\UiFramework\Components\Navigation\SideBar;

enum SideBarComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case EXPAND = 'expand';
    case COLLAPSE = 'collapse';
    case TOGGLE = 'toggle';
    case RESET = 'reset';
}
