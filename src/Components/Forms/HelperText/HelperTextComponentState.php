<?php

namespace W4\UI\Framework\Components\Forms\HelperText;

enum HelperTextComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
