<?php

namespace W4\UiFramework\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Components\UI\Divider\Divider;
use W4\UiFramework\Components\UI\Heading\Heading;
use W4\UiFramework\Components\UI\Icon\Icon;
use W4\UiFramework\Components\UI\IconButton\IconButton;
use W4\UiFramework\Components\UI\Label\Label;
use W4\UiFramework\Components\UI\Link\Link;
use W4\UiFramework\Components\UI\Text\Text;
use W4\UiFramework\Components\Forms\CheckBox\CheckBox;
use W4\UiFramework\Components\Forms\FielError\FieldError;
use W4\UiFramework\Components\Forms\HelperText\HelperText;
use W4\UiFramework\Components\Forms\Input\Input;
use W4\UiFramework\Components\Forms\Radio\Radio;
use W4\UiFramework\Components\Forms\Select\Select;
use W4\UiFramework\Core\ComponentFactory;
use W4\UiFramework\Core\ComponentRegistry;
use W4\UiFramework\Core\RendererPipeline;
use W4\UiFramework\Core\RuntimeRenderer;
use W4\UiFramework\Core\ThemeResolverPipeline;
use W4\UiFramework\Managers\RendererManager;
use W4\UiFramework\Managers\ThemeManager;
use W4\UiFramework\Renderers\BladeRenderer;
use W4\UiFramework\Support\W4UiManager;
use W4\UiFramework\Themes\Bootstrap\BootstrapTheme;
use W4\UiFramework\Themes\DaisyUI\DaisyTheme;
use W4\UiFramework\Themes\Tailwind\TailwindTheme;
use W4\UiFramework\View\Components\Render as RenderComponent;
// Componentes w4-component
use W4\UiFramework\View\Components\UI\Button as ButtonBladeComponent;
use W4\UiFramework\View\Components\UI\Divider as DividerBladeComponent;
use W4\UiFramework\View\Components\UI\Heading as HeadingBladeComponent;
use W4\UiFramework\View\Components\UI\Icon as IconBladeComponent;
use W4\UiFramework\View\Components\UI\IconButton as IconButtonBladeComponent;
use W4\UiFramework\View\Components\UI\Label as LabelBladeComponent;
use W4\UiFramework\View\Components\UI\Link as LinkBladeComponent;
use W4\UiFramework\View\Components\UI\Text as TextBladeComponent;
use W4\UiFramework\View\Components\Forms\CheckBox as CheckBoxBladeComponent;
use W4\UiFramework\View\Components\Forms\FieldError as FieldErrorBladeComponent;
use W4\UiFramework\View\Components\Forms\HelperText as HelperTextBladeComponent;
use W4\UiFramework\View\Components\Forms\Input as InputBladeComponent;
use W4\UiFramework\View\Components\Forms\Radio as RadioBladeComponent;
use W4\UiFramework\View\Components\Forms\Select as SelectBladeComponent;

class W4UiFrameworkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/w4-ui-framework.php',
            'w4-ui-framework'
        );

        $this->app->singleton(ComponentRegistry::class, function () {
            return (new ComponentRegistry())
                ->register('button', Button::class)
                ->register('divider', Divider::class)
                ->register('heading', Heading::class)
                ->register('icon', Icon::class)
                ->register('icon-button', IconButton::class)
                ->register('label', Label::class)
                ->register('link', Link::class)
                ->register('text', Text::class)
                ->register('checkbox', CheckBox::class)
                ->register('field-error', FieldError::class)
                ->register('helper-text', HelperText::class)
                ->register('radio', Radio::class)
                ->register('select', Select::class)
                ->register('input', Input::class);
        });

        $this->app->singleton(ComponentFactory::class, function ($app) {
            return new ComponentFactory(
                $app->make(ComponentRegistry::class)
            );
        });

        $this->app->singleton(ThemeManager::class, function () {
            $manager = new ThemeManager();

            $manager->register('bootstrap', new BootstrapTheme());
            $manager->register('daisyui', new DaisyTheme());
            $manager->register('tailwind', new TailwindTheme());

            return $manager;
        });

        $this->app->singleton(RendererManager::class, function () {
            $manager = new RendererManager();

            $manager->register('blade', new BladeRenderer());

            return $manager;
        });

        $this->app->singleton(ThemeResolverPipeline::class, function ($app) {
            return new ThemeResolverPipeline(
                $app->make(ThemeManager::class)
            );
        });

        $this->app->singleton(RendererPipeline::class, function ($app) {
            return new RendererPipeline(
                $app->make(RendererManager::class)
            );
        });

        $this->app->singleton(RuntimeRenderer::class, function ($app) {
            return new RuntimeRenderer(
                $app->make(ThemeResolverPipeline::class),
                $app->make(RendererPipeline::class)
            );
        });

        $this->app->singleton(W4UiManager::class, function ($app) {
            return new W4UiManager(
                $app->make(RuntimeRenderer::class),
                $app['view']
            );
        });

        $this->app->singleton('w4.ui', function ($app) {
            return $app->make(W4UiManager::class);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/w4-ui-framework.php' => config_path('w4-ui-framework.php'),
        ], 'w4-ui-config'); // php artisan vendor:publish --tag=w4-ui-config --path=config/w4-ui-framework.php

        $this->publishes([
            __DIR__ . '/../../stub/w4.ui.log' => storage_path('logs/w4.ui.log'),
        ], 'w4-ui-log'); // php artisan vendor:publish --tag=w4-ui-log --path=storage/logs/w4.ui.log

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'w4-ui');

        $prefix = $this->resolveComponentPrefix();

        Blade::component($this->componentAlias($prefix, 'render'), RenderComponent::class);
        Blade::component($this->componentAlias($prefix, 'button'), ButtonBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'divider'), DividerBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'heading'), HeadingBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'icon'), IconBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'icon-button'), IconButtonBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'label'), LabelBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'link'), LinkBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'text'), TextBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'checkbox'), CheckBoxBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'field-error'), FieldErrorBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'helper-text'), HelperTextBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'radio'), RadioBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'select'), SelectBladeComponent::class);
        Blade::component($this->componentAlias($prefix, 'input'), InputBladeComponent::class);
    }

    protected function resolveComponentPrefix(): string
    {
        $prefix = config('w4-ui-framework.w4_ui_component_prefix');

        // if (! is_string($prefix) || $prefix === '') {
        //     $prefix = config('w4-ui-framework.w4_ui_component_prefix');
        // }

        if (! is_string($prefix) || $prefix === '') {
            $prefix = 'w4';
        }

        $prefix = (string) $prefix;
        $normalized = strtolower(trim($prefix));
        $normalized = str_replace(['_', ' '], '-', $normalized);

        return trim($normalized, '-');
    }

    protected function componentAlias(string $prefix, string $name): string
    {
        if ($prefix === '') {
            return $name;
        }

        return $prefix . '-' . $name;
    }
}
