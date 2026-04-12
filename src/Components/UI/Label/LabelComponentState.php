<?php

namespace W4\UI\Framework\Components\UI\Label;

enum LabelComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
}
