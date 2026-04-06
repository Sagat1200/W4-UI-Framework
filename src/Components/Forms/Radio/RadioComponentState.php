<?php

namespace W4\UiFramework\Components\Forms\Radio;

enum RadioComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case READONLY = 'readonly';
    case INVALID = 'invalid';
    case VALID = 'valid';
    case LOADING = 'loading';
}