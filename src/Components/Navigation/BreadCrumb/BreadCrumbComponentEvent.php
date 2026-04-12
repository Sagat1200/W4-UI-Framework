<?php

namespace W4\UI\Framework\Components\Navigation\BreadCrumb;

enum BreadCrumbComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case EXPAND = 'expand';
    case COLLAPSE = 'collapse';
    case RESET = 'reset';
}
