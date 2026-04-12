<?php

namespace W4\UI\Framework\Components\Forms\FielError;

enum FieldErrorComponentEvent: string
{
    case ACTIVATE = 'activate';
    case DEACTIVATE = 'deactivate';
    case DISABLE = 'disable';
    case ENABLE = 'enable';
    case HIDE = 'hide';
    case SHOW = 'show';
    case RESET = 'reset';
}
