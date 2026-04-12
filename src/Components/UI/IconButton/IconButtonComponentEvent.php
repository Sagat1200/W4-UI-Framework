<?php

namespace W4\UI\Framework\Components\UI\IconButton;

enum IconButtonComponentEvent: string
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
