<?php

namespace W4\UiFramework\Themes\Tailwind;

use W4\UiFramework\Core\AbstractTheme;
use W4\UiFramework\Themes\Tailwind\Components\Forms\InputThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\ButtonThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\DividerThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\HeadingThemeResolver;

class TailwindTheme extends AbstractTheme
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
        return 'tailwind';
    }
}
