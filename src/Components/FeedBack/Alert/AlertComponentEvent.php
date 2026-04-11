<?php

namespace W4\UiFramework\Components\FeedBack\Alert;

enum AlertComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case DISMISS = 'dismiss';
    case RESET = 'reset';
}
