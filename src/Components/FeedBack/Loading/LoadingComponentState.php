<?php

namespace W4\UiFramework\Components\FeedBack\Loading;

enum LoadingComponentState: string
{
    case ENABLED = 'enabled';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
    case HIDDEN = 'hidden';
    case LOADING = 'loading';
}
