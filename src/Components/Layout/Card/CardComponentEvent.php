<?php

namespace W4\UI\Framework\Components\Layout\Card;

enum CardComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case COLLAPSE = 'collapse';
    case EXPAND = 'expand';
    case RESET = 'reset';
}
