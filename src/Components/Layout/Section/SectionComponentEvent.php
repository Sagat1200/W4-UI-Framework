<?php

namespace W4\UiFramework\Components\Layout\Section;

enum SectionComponentEvent: string
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
