<?php

namespace W4\UI\Framework\Components\Interactive\Modal;

enum ModalComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case OPEN = 'open';
}
