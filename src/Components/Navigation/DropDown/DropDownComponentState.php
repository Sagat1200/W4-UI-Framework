<?php

namespace W4\UiFramework\Components\Navigation\DropDown;

enum DropDownComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case OPEN = 'open';
}
