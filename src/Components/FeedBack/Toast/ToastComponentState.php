<?php

namespace W4\UI\Framework\Components\FeedBack\Toast;

enum ToastComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case DISMISSED = 'dismissed';
}
