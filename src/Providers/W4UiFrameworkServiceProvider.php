<?php

namespace W4\UiFramework\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Components\UI\Input\Input;
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
use W4\UiFramework\View\Components\Render as RenderComponent;
// Componentes w4-component
use W4\UiFramework\View\Components\UI\Button as ButtonBladeComponent;
use W4\UiFramework\View\Components\UI\Input as InputBladeComponent;

class W4UiFrameworkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/w4-ui-framework.php',
            'w4_ui_framework'
        );

        $this->app->singleton(ComponentRegistry::class, function () {
            return (new ComponentRegistry())
                ->register('button', Button::class)
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

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'w4-ui');

        Blade::component('w4-render', RenderComponent::class);

        Blade::component('w4-button', ButtonBladeComponent::class);
        Blade::component('w4-input', InputBladeComponent::class);
    }
}
