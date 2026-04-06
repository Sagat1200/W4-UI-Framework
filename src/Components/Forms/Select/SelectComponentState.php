<?php

namespace W4\UiFramework\Components\Forms\Select;

enum SelectComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case READONLY = 'readonly';
    case INVALID = 'invalid';
    case VALID = 'valid';
    case LOADING = 'loading';
}