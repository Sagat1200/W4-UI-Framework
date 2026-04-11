<?php

namespace W4\UiFramework\Components\Navigation\Menu;

enum MenuComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case OPEN = 'open';
}
