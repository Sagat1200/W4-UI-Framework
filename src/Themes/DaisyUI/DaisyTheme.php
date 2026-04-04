<?php

namespace W4\UiFramework\Themes\DaisyUI;

use W4\UiFramework\Core\AbstractTheme;
use W4\UiFramework\Themes\DaisyUI\Components\UI\ButtonThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\UI\DividerThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\UI\HeadingThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\Forms\InputThemeResolver;

class DaisyTheme extends AbstractTheme
{
    public function __construct()
    {
        $this->registerResolver('button', new ButtonThemeResolver());
        $this->registerResolver('divider', new DividerThemeResolver());
        $this->registerResolver('heading', new HeadingThemeResolver());
        $this->registerResolver('input', new InputThemeResolver());
    }

    public function name(): string
    {
        return 'daisyui';
    }
}
