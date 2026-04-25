<?php

namespace W4\UI\Framework\Themes\NativeUI;

use W4\UI\Framework\Core\AbstractTheme;
use W4\UI\Framework\Themes\NativeUI\UI\Button\ButtonTheme;

class NativeUITheme extends AbstractTheme
{
    public function __construct()
    {
        $this->registerResolver('button', new ButtonTheme());
    }

    public function name(): string
    {
        return 'w4native';
    }
}