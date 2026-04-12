<?php

namespace W4\UI\Framework\Components\Forms\Input;

enum InputComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case READONLY = 'readonly';
    case INVALID = 'invalid';
    case VALID = 'valid';
    case LOADING = 'loading';
}
