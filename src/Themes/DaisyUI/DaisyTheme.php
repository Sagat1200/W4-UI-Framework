<?php

namespace W4\UiFramework\Themes\DaisyUI;

use W4\UiFramework\Core\AbstractTheme;
use W4\UiFramework\Themes\DaisyUI\Components\Forms\CheckBoxThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\Forms\FieldErrorThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\UI\ButtonThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\UI\DividerThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\UI\HeadingThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\UI\IconThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\UI\IconButtonThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\UI\LabelThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\UI\LinkThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\UI\TextThemeResolver;
use W4\UiFramework\Themes\DaisyUI\Components\Forms\InputThemeResolver;

class DaisyTheme extends AbstractTheme
{
    public function __construct()
    {
        $this->registerResolver('button', new ButtonThemeResolver());
        $this->registerResolver('divider', new DividerThemeResolver());
        $this->registerResolver('heading', new HeadingThemeResolver());
        $this->registerResolver('icon', new IconThemeResolver());
        $this->registerResolver('icon-button', new IconButtonThemeResolver());
        $this->registerResolver('label', new LabelThemeResolver());
        $this->registerResolver('link', new LinkThemeResolver());
        $this->registerResolver('text', new TextThemeResolver());
        $this->registerResolver('input', new InputThemeResolver());
        $this->registerResolver('checkbox', new CheckBoxThemeResolver());
        $this->registerResolver('field-error', new FieldErrorThemeResolver());
    }

    public function name(): string
    {
        return 'daisyui';
    }
}
