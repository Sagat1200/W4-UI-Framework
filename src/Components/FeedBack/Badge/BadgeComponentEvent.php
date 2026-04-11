<?php

namespace W4\UiFramework\Components\FeedBack\Badge;

enum BadgeComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case HIGHLIGHT = 'highlight';
    case NORMALIZE = 'normalize';
    case RESET = 'reset';
}
