<?php

namespace W4\UI\Framework\Components\FeedBack\Alert;

enum AlertComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case DISMISSED = 'dismissed';
}
