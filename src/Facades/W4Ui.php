<?php

namespace W4\UI\Framework\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string render(\W4\UI\Framework\Contracts\ComponentInterface $component, ?string $renderer = null)
 * @method static \Illuminate\Contracts\View\View|string view(\W4\UI\Framework\Contracts\ComponentInterface $component, ?string $renderer = null)
 * @method static mixed payload(\W4\UI\Framework\Contracts\ComponentInterface $component, ?string $renderer = null)
 */
class W4Ui extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'w4.ui';
    }
}