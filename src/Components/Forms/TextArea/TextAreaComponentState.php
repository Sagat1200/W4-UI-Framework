<?php

namespace W4\UI\Framework\Components\Forms\TextArea;

enum TextAreaComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case READONLY = 'readonly';
    case INVALID = 'invalid';
    case VALID = 'valid';
    case LOADING = 'loading';
}
