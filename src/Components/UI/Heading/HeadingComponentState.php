<?php

namespace W4\UiFramework\Components\UI\Heading;

enum HeadingComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}