<?php

namespace W4\UiFramework\Components\Layout\Panel;

enum PanelComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case COLLAPSED = 'collapsed';
}
