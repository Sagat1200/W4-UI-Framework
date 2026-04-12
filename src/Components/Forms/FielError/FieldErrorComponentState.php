<?php

namespace W4\UI\Framework\Components\Forms\FielError;

enum FieldErrorComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
