<?php

namespace W4\UI\Framework\Components\Navigation\Tab\TabPane;

enum TabPaneComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case HIDE = 'hide';
    case SHOW = 'show';
    case RESET = 'reset';
}
