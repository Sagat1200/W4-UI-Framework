<?php

namespace W4\UiFramework\Components\UI\Link;

enum LinkComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
