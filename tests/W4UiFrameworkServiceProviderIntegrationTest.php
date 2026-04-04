<?php

namespace W4\UiFramework\Tests;

use Illuminate\Support\Facades\Log;
use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;
use W4\UiFramework\Components\Forms\Input\Input;
use W4\UiFramework\Core\ComponentFactory;
use W4\UiFramework\Core\ComponentRegistry;
use W4\UiFramework\Managers\RendererManager;
use W4\UiFramework\Managers\ThemeManager;
use W4\UiFramework\Providers\W4UiFrameworkServiceProvider;
use W4\UiFramework\Themes\Tailwind\Components\Forms\InputThemeResolver as TailwindInputThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\ButtonThemeResolver as TailwindButtonThemeResolver;
use W4\UiFramework\View\Components\Render;
use W4\UiFramework\View\Components\Forms\Input as InputBladeComponent;
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

    public function test_registers_blade_component_with_custom_prefix_from_config(): void
    {
        config()->set('w4_ui_framework.w4_ui_component_prefix', 'admin');

        $provider = new W4UiFrameworkServiceProvider($this->app);
        $provider->boot();

        $aliases = $this->app->make('blade.compiler')->getClassComponentAliases();

        $this->assertArrayHasKey('admin-render', $aliases);
        $this->assertSame(Render::class, $aliases['admin-render']);
        $this->assertArrayHasKey('admin-button', $aliases);
        $this->assertArrayHasKey('admin-input', $aliases);
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

    public function test_blade_renderer_detects_any_components_subfolder_except_blade(): void
    {
        $componentsRoot = dirname(__DIR__) . '/resources/views/components';
        $layoutDir = $componentsRoot . '/layout';
        $layoutViewPath = $layoutDir . '/renderer-probe.blade.php';
        $bladeDir = $componentsRoot . '/blade';
        $bladeViewPath = $bladeDir . '/renderer-probe.blade.php';
        $layoutDirCreated = false;

        if (! is_dir($layoutDir)) {
            mkdir($layoutDir, 0777, true);
            $layoutDirCreated = true;
        }

        file_put_contents($layoutViewPath, '<div>layout</div>');
        file_put_contents($bladeViewPath, '<div>blade</div>');

        try {
            $component = new class implements \W4\UiFramework\Contracts\ComponentInterface
            {
                public function componentName(): string
                {
                    return 'renderer-probe';
                }

                public function toThemeContext(): array
                {
                    return [];
                }

                public function toArray(): array
                {
                    return [];
                }
            };

            $payload = $this->app->make('w4.ui')->payload($component);

            $this->assertSame('w4-ui::components.layout.renderer-probe', $payload['view']);
        } finally {
            if (file_exists($layoutViewPath)) {
                unlink($layoutViewPath);
            }

            if (file_exists($bladeViewPath)) {
                unlink($bladeViewPath);
            }

            if ($layoutDirCreated && is_dir($layoutDir)) {
                rmdir($layoutDir);
            }
        }
    }

    public function test_blade_wrappers_map_component_id_to_meta_and_attributes(): void
    {
        $bladeButton = new ButtonBladeComponent(
            label: 'Guardar',
            componentId: 12547
        );

        $buttonPayload = $this->app->make('w4.ui')->payload($bladeButton->component());

        $this->assertSame(12547, $buttonPayload['data']['meta']['component_id']);
        $this->assertSame('12547', $buttonPayload['data']['attributes']['data-component-id']);

        $bladeInput = new InputBladeComponent(
            label: 'Correo',
            componentId: 'audit-input-01'
        );

        $inputPayload = $this->app->make('w4.ui')->payload($bladeInput->component());

        $this->assertSame('audit-input-01', $inputPayload['data']['meta']['component_id']);
        $this->assertSame('audit-input-01', $inputPayload['data']['attributes']['data-component-id']);
    }

    public function test_w4_debug_payload_returns_summary_keys(): void
    {
        $bladeButton = new ButtonBladeComponent(
            label: 'Guardar',
            componentId: 12547,
            active: true
        );

        $summary = w4_debug_payload($bladeButton->component());

        $this->assertSame('button', $summary['component']);
        $this->assertSame('active', $summary['state']);
        $this->assertSame(12547, $summary['component_id']);
        $this->assertSame('12547', $summary['dom_component_id']);
        $this->assertIsArray($summary['payload']);
    }

    public function test_logs_component_debug_when_w4_ui_debug_is_enabled_and_component_has_data_component_id(): void
    {
        config()->set('w4_ui_framework.w4_ui_debug', true);
        $logPath = storage_path('logs/w4.ui.log');

        if (is_file($logPath)) {
            unlink($logPath);
        }

        $bladeButton = new ButtonBladeComponent(
            label: 'Guardar',
            componentId: 12547,
            active: true
        );

        $this->app->make('w4.ui')->payload($bladeButton->component());

        $this->assertFileExists($logPath);

        $logContent = file_get_contents($logPath);
        $this->assertIsString($logContent);
        $this->assertStringContainsString('w4_ui.component_debug', $logContent);
        $this->assertStringContainsString('"origin":"payload"', $logContent);
        $this->assertStringContainsString('"component":"button"', $logContent);
        $this->assertStringContainsString('"component_id":12547', $logContent);
        $this->assertStringContainsString('"dom_component_id":"12547"', $logContent);
        $this->assertStringContainsString('"state":"active"', $logContent);
    }

    public function test_user_width_class_keeps_variant_classes_in_rendered_html(): void
    {
        $input = Input::make('Correo')
            ->theme('daisyui')
            ->variant('primary')
            ->size('xs')
            ->attribute('class', 'w-52');

        $inputHtml = $this->app->make('w4.ui')->render($input);
        $inputPayload = $this->app->make('w4.ui')->payload($input);

        $this->assertStringContainsString('input-primary', $inputHtml);
        $this->assertStringContainsString('w-52', $inputHtml);
        preg_match('/<input\b[^>]*>/i', $inputHtml, $inputTagMatches);
        $this->assertNotEmpty($inputTagMatches);
        $this->assertSame(1, substr_count($inputTagMatches[0], 'class="'));
        $this->assertStringContainsString('w-52', $inputPayload['theme']['classes']['input']);
        $this->assertStringNotContainsString('w-full', $inputPayload['theme']['classes']['input']);

        $inputWithHeight = Input::make('Correo')
            ->theme('daisyui')
            ->variant('primary')
            ->size('xs')
            ->attribute('class', 'h-14');

        $inputHeightPayload = $this->app->make('w4.ui')->payload($inputWithHeight);

        $this->assertStringContainsString('input-primary', $inputHeightPayload['theme']['classes']['input']);
        $this->assertStringContainsString('h-14', $inputHeightPayload['theme']['classes']['input']);
        $this->assertStringNotContainsString('input-xs', $inputHeightPayload['theme']['classes']['input']);

        $button = Button::make('Guardar')
            ->theme('daisyui')
            ->variant('primary')
            ->attribute('class', 'w-52');

        $buttonHtml = $this->app->make('w4.ui')->render($button);

        $this->assertStringContainsString('btn-primary', $buttonHtml);
        $this->assertStringContainsString('w-52', $buttonHtml);
        preg_match('/<button\b[^>]*>/i', $buttonHtml, $buttonTagMatches);
        $this->assertNotEmpty($buttonTagMatches);
        $this->assertSame(1, substr_count($buttonTagMatches[0], 'class="'));

        $buttonWithHeight = Button::make('Guardar')
            ->theme('daisyui')
            ->variant('primary')
            ->size('sm')
            ->attribute('class', 'h-14');

        $buttonHeightPayload = $this->app->make('w4.ui')->payload($buttonWithHeight);

        $this->assertStringContainsString('btn-primary', $buttonHeightPayload['theme']['classes']['root']);
        $this->assertStringContainsString('h-14', $buttonHeightPayload['theme']['classes']['root']);
        $this->assertStringNotContainsString('btn-sm', $buttonHeightPayload['theme']['classes']['root']);
    }

    public function test_tailwind_theme_resolvers_merge_variant_with_width_and_height_utilities(): void
    {
        $inputResolver = new TailwindInputThemeResolver();
        $inputClasses = $inputResolver->classes([
            'variant' => 'primary',
            'size' => 'xs',
            'attributes' => ['class' => 'w-52 h-14'],
        ]);

        $this->assertStringContainsString('focus:ring-blue-500', $inputClasses['input']);
        $this->assertStringContainsString('w-52', $inputClasses['input']);
        $this->assertStringContainsString('h-14', $inputClasses['input']);
        $this->assertStringNotContainsString('w-full', $inputClasses['input']);
        $this->assertStringNotContainsString('py-1', $inputClasses['input']);

        $buttonResolver = new TailwindButtonThemeResolver();
        $buttonClasses = $buttonResolver->classes([
            'variant' => 'primary',
            'size' => 'sm',
            'attributes' => ['class' => 'h-14 w-52'],
        ]);

        $this->assertStringContainsString('bg-blue-600', $buttonClasses['root']);
        $this->assertStringContainsString('h-14', $buttonClasses['root']);
        $this->assertStringContainsString('w-52', $buttonClasses['root']);
        $this->assertStringNotContainsString('py-1.5', $buttonClasses['root']);
    }
}
