<?php

namespace W4\UiFramework\Themes\Bootstrap;

use W4\UiFramework\Core\AbstractTheme;
use W4\UiFramework\Themes\Bootstrap\Components\UI\ButtonThemeResolver;
use W4\UiFramework\Themes\Bootstrap\Components\UI\DividerThemeResolver;
use W4\UiFramework\Themes\Bootstrap\Components\UI\HeadingThemeResolver;
use W4\UiFramework\Themes\Bootstrap\Components\Forms\InputThemeResolver;

class BootstrapTheme extends AbstractTheme
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
        return 'bootstrap';
    }
}
