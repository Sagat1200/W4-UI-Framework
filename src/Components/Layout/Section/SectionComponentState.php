<?php

namespace W4\UiFramework\Components\Layout\Section;

enum SectionComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case COLLAPSED = 'collapsed';
}
