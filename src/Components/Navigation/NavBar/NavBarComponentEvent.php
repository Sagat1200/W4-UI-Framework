<?php

namespace W4\UI\Framework\Components\Navigation\NavBar;

enum NavBarComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case EXPAND = 'expand';
    case COLLAPSE = 'collapse';
    case TOGGLE_MOBILE = 'toggle_mobile';
    case RESET = 'reset';
}
