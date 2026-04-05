<?php

namespace W4\UiFramework\Components\UI\Text;

enum TextComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
