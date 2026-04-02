<?php

namespace W4\UiFramework\Tests;

use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Components\UI\Input\Input;
use W4\UiFramework\Core\ComponentFactory;
use W4\UiFramework\Core\ComponentRegistry;
use W4\UiFramework\Managers\RendererManager;
use W4\UiFramework\Managers\ThemeManager;
use W4\UiFramework\Providers\W4UiFrameworkServiceProvider;
use W4\UiFramework\View\Components\Render;

class W4UiFrameworkServiceProviderIntegrationTest extends TestCase
{
    public function test_registers_core_bindings(): void
    {
        $this->assertTrue($this->app->bound(ComponentRegistry::class));
        $this->assertTrue($this->app->bound(ComponentFactory::class));
        $this->assertTrue($this->app->bound(ThemeManager::class));
        $this->assertTrue($this->app->bound(RendererManager::class));
        $this->assertTrue($this->app->bound('w4.ui'));
    }

    public function test_registers_component_aliases_in_registry_factory(): void
    {
        $factory = $this->app->make(ComponentFactory::class);

        $button = $factory->make('button');
        $input = $factory->make('input');

        $this->assertInstanceOf(Button::class, $button);
        $this->assertInstanceOf(Input::class, $input);
    }

    public function test_loads_default_config_values(): void
    {
        $this->assertSame('bootstrap', config('w4_ui_framework.theme'));
        $this->assertSame('blade', config('w4_ui_framework.renderer'));
    }

    public function test_registers_blade_component_and_view_namespace(): void
    {
        $aliases = $this->app->make('blade.compiler')->getClassComponentAliases();

        $this->assertArrayHasKey('w4-render', $aliases);
        $this->assertSame(Render::class, $aliases['w4-render']);
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.ui.button'));
    }

    public function test_publishes_config_file_to_expected_target(): void
    {
        $publishes = W4UiFrameworkServiceProvider::pathsToPublish(
            W4UiFrameworkServiceProvider::class,
            'w4-ui-config'
        );

        $this->assertIsArray($publishes);
        $this->assertContains($this->app->configPath('w4-ui-framework.php'), array_values($publishes));

        $sources = array_keys($publishes);
        $matchedSource = collect($sources)->first(function (string $source) {
            $normalized = str_replace('\\', '/', $source);

            return str_ends_with($normalized, '/config/w4-ui-framework.php');
        });

        $this->assertIsString($matchedSource);
    }
}
