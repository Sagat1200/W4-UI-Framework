<?php

namespace W4\UI\Framework\Components\UI\IconButton;

enum IconButtonComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case LOADING = 'loading';
    case READONLY = 'readonly';
    case ACTIVE = 'active';
}
