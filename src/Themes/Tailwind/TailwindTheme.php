<?php

namespace W4\UiFramework\Themes\Tailwind;

use W4\UiFramework\Core\AbstractTheme;
use W4\UiFramework\Themes\Tailwind\Components\Forms\CheckBoxThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\Forms\FieldErrorThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\Forms\HelperTextThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\Forms\InputThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\ButtonThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\DividerThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\HeadingThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\IconThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\IconButtonThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\LabelThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\LinkThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\TextThemeResolver;

class TailwindTheme extends AbstractTheme
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
        $this->registerResolver('helper-text', new HelperTextThemeResolver());
    }

    public function name(): string
    {
        return 'tailwind';
    }
}
