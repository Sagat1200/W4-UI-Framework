<?php

namespace W4\UI\Framework\Components\FeedBack\Progress;

enum ProgressComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case START_LOADING = 'start_loading';
    case STOP_LOADING = 'stop_loading';
    case SET_INDETERMINATE = 'set_indeterminate';
    case SET_DETERMINATE = 'set_determinate';
    case RESET = 'reset';
}
