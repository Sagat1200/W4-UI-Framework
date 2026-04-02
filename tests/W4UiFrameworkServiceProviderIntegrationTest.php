<?php

namespace W4\UiFramework\Tests;

use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;
use W4\UiFramework\Components\UI\Input\Input;
use W4\UiFramework\Core\ComponentFactory;
use W4\UiFramework\Core\ComponentRegistry;
use W4\UiFramework\Managers\RendererManager;
use W4\UiFramework\Managers\ThemeManager;
use W4\UiFramework\Providers\W4UiFrameworkServiceProvider;
use W4\UiFramework\View\Components\Render;
use W4\UiFramework\View\Components\UI\Button as ButtonBladeComponent;

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

    public function test_button_state_machine_affects_resolved_theme_classes(): void
    {
        $daisyButton = Button::make('Guardar')
            ->theme('daisyui')
            ->dispatch(ButtonComponentEvent::SET_ACTIVE);

        $daisyPayload = $this->app->make('w4.ui')->payload($daisyButton);

        $this->assertSame('active', $daisyPayload['data']['state']);
        $this->assertStringContainsString('btn-active', $daisyPayload['theme']['classes']['root']);
        $this->assertSame('true', $daisyPayload['theme']['attributes']['aria-pressed']);

        $bootstrapButton = Button::make('Guardar')
            ->theme('bootstrap')
            ->dispatch(ButtonComponentEvent::SET_ACTIVE);

        $bootstrapPayload = $this->app->make('w4.ui')->payload($bootstrapButton);

        $this->assertStringContainsString('active', $bootstrapPayload['theme']['classes']['root']);
        $this->assertSame('true', $bootstrapPayload['theme']['attributes']['aria-pressed']);
    }

    public function test_blade_button_maps_state_props_to_state_machine_events(): void
    {
        $activeBladeButton = new ButtonBladeComponent(
            label: 'Guardar',
            theme: 'daisyui',
            active: true
        );

        $activePayload = $this->app->make('w4.ui')->payload($activeBladeButton->component());

        $this->assertSame('active', $activePayload['data']['state']);
        $this->assertStringContainsString('btn-active', $activePayload['theme']['classes']['root']);
        $this->assertSame('true', $activePayload['theme']['attributes']['aria-pressed']);

        $readonlyBladeButton = new ButtonBladeComponent(
            label: 'Guardar',
            theme: 'bootstrap',
            readonly: true
        );

        $readonlyPayload = $this->app->make('w4.ui')->payload($readonlyBladeButton->component());

        $this->assertSame('readonly', $readonlyPayload['data']['state']);
        $this->assertTrue($readonlyPayload['theme']['attributes']['disabled']);
        $this->assertSame('true', $readonlyPayload['theme']['attributes']['aria-disabled']);

        $loadingHasPriorityBladeButton = new ButtonBladeComponent(
            label: 'Guardar',
            loading: true,
            disabled: true,
            readonly: true,
            active: true
        );

        $loadingPayload = $this->app->make('w4.ui')->payload($loadingHasPriorityBladeButton->component());

        $this->assertSame('loading', $loadingPayload['data']['state']);
    }
}
