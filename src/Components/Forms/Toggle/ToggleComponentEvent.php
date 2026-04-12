<?php

namespace W4\UI\Framework\Components\Forms\Toggle;

enum ToggleComponentEvent: string
{
    case FOCUS = 'focus';
    case BLUR = 'blur';
    case CHANGE = 'change';
    case CHECK = 'check';
    case UNCHECK = 'uncheck';
    case TOGGLE = 'toggle';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case SET_READONLY = 'set_readonly';
    case SET_INVALID = 'set_invalid';
    case SET_VALID = 'set_valid';
    case START_LOADING = 'start_loading';
    case FINISH_LOADING = 'finish_loading';
    case RESET = 'reset';
}
