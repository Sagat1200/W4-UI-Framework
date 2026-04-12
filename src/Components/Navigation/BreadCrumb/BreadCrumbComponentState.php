<?php

namespace W4\UI\Framework\Components\Navigation\BreadCrumb;

enum BreadCrumbComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case COLLAPSED = 'collapsed';
}
