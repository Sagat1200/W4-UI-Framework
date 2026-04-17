<?php

namespace W4\UI\Framework\Components\Navigation\Tab\TabPane;

enum TabPaneComponentState: string
{
    case ENABLED = 'enabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
