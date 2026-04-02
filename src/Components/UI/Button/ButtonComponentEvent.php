<?php

namespace W4\UiFramework\Components\UI\Button;

enum ButtonComponentEvent: string
{
    case CLICK = 'click';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case START_LOADING = 'start_loading';
    case FINISH_LOADING = 'finish_loading';
    case SET_READONLY = 'set_readonly';
    case SET_ACTIVE = 'set_active';
    case RESET = 'reset';
}
