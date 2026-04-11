<?php

namespace W4\UiFramework\Components\Navigation\Tab;

enum TabComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case SELECTED = 'selected';
}
