<?php

namespace W4\UiFramework\Tests;

use W4\UiFramework\Components\Forms\Input\Input;
use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Core\ComponentFactory;
use W4\UiFramework\Core\ComponentRegistry;
use W4\UiFramework\Managers\RendererManager;
use W4\UiFramework\Managers\ThemeManager;
use W4\UiFramework\Themes\W4Native\W4NativeTheme;
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

    public function test_loads_native_theme_as_default_config(): void
    {
        $this->assertSame('w4native', config('w4-ui-framework.theme'));
        $this->assertSame('blade', config('w4-ui-framework.renderer'));
    }

    public function test_theme_manager_registers_only_native_theme(): void
    {
        $themeManager = $this->app->make(ThemeManager::class);
        $registeredThemes = $themeManager->all();

        $this->assertInstanceOf(W4NativeTheme::class, $themeManager->resolve('w4native'));
        $this->assertCount(1, $registeredThemes);
        $this->assertArrayHasKey('w4native', $registeredThemes);
    }

    public function test_registers_blade_component_aliases(): void
    {
        $aliases = $this->app->make('blade.compiler')->getClassComponentAliases();

        $this->assertArrayHasKey('w4-render', $aliases);
        $this->assertSame(Render::class, $aliases['w4-render']);
        $this->assertArrayHasKey('w4-button', $aliases);
        $this->assertArrayHasKey('w4-input', $aliases);
    }

    public function test_payload_resolves_with_native_theme(): void
    {
        $payload = $this->app->make('w4.ui')->payload(
            Button::make('Guardar')->theme('w4native')
        );

        $this->assertIsArray($payload);
        $this->assertSame('w4native', $payload['data']['theme']);
        $this->assertSame('button', $payload['component']);
        $this->assertIsArray($payload['theme']['classes']);
        $this->assertIsArray($payload['theme']['attributes']);
    }

    public function test_can_render_input_with_native_theme(): void
    {
        $html = $this->app->make('w4.ui')->render(
            Input::make('Correo')->name('email')->theme('w4native')
        );

        $this->assertIsString($html);
        $this->assertNotSame('', trim($html));
        $this->assertStringContainsString('Correo', $html);
    }
}
