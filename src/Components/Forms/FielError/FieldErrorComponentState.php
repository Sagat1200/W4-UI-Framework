<?php

namespace W4\UiFramework\Components\Forms\FielError;

enum FieldErrorComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}