<?php

namespace W4\UiFramework\Tests;

use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;
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
use W4\UiFramework\Core\ComponentFactory;
use W4\UiFramework\Core\ComponentRegistry;
use W4\UiFramework\Managers\RendererManager;
use W4\UiFramework\Managers\ThemeManager;
use W4\UiFramework\Providers\W4UiFrameworkServiceProvider;
use W4\UiFramework\Themes\Tailwind\Components\Forms\InputThemeResolver as TailwindInputThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\ButtonThemeResolver as TailwindButtonThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\DividerThemeResolver as TailwindDividerThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\HeadingThemeResolver as TailwindHeadingThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\IconThemeResolver as TailwindIconThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\IconButtonThemeResolver as TailwindIconButtonThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\LabelThemeResolver as TailwindLabelThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\LinkThemeResolver as TailwindLinkThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\UI\TextThemeResolver as TailwindTextThemeResolver;
use W4\UiFramework\Themes\Tailwind\Components\Forms\HelperTextThemeResolver as TailwindHelperTextThemeResolver;
use W4\UiFramework\View\Components\Render;
use W4\UiFramework\View\Components\Forms\CheckBox as CheckBoxBladeComponent;
use W4\UiFramework\View\Components\Forms\FieldError as FieldErrorBladeComponent;
use W4\UiFramework\View\Components\Forms\HelperText as HelperTextBladeComponent;
use W4\UiFramework\View\Components\Forms\Input as InputBladeComponent;
use W4\UiFramework\View\Components\UI\Button as ButtonBladeComponent;
use W4\UiFramework\View\Components\UI\Divider as DividerBladeComponent;
use W4\UiFramework\View\Components\UI\Heading as HeadingBladeComponent;
use W4\UiFramework\View\Components\UI\Icon as IconBladeComponent;
use W4\UiFramework\View\Components\UI\IconButton as IconButtonBladeComponent;
use W4\UiFramework\View\Components\UI\Label as LabelBladeComponent;
use W4\UiFramework\View\Components\UI\Link as LinkBladeComponent;
use W4\UiFramework\View\Components\UI\Text as TextBladeComponent;

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
        $divider = $factory->make('divider');
        $heading = $factory->make('heading');
        $icon = $factory->make('icon');
        $iconButton = $factory->make('icon-button');
        $label = $factory->make('label');
        $link = $factory->make('link');
        $text = $factory->make('text');
        $checkbox = $factory->make('checkbox');
        $fieldError = $factory->make('field-error');
        $helperText = $factory->make('helper-text');
        $input = $factory->make('input');

        $this->assertInstanceOf(Button::class, $button);
        $this->assertInstanceOf(Divider::class, $divider);
        $this->assertInstanceOf(Heading::class, $heading);
        $this->assertInstanceOf(Icon::class, $icon);
        $this->assertInstanceOf(IconButton::class, $iconButton);
        $this->assertInstanceOf(Label::class, $label);
        $this->assertInstanceOf(Link::class, $link);
        $this->assertInstanceOf(Text::class, $text);
        $this->assertInstanceOf(CheckBox::class, $checkbox);
        $this->assertInstanceOf(FieldError::class, $fieldError);
        $this->assertInstanceOf(HelperText::class, $helperText);
        $this->assertInstanceOf(Input::class, $input);
    }

    public function test_loads_default_config_values(): void
    {
        $this->assertSame('bootstrap', config('w4-ui-framework.theme'));
        $this->assertSame('blade', config('w4-ui-framework.renderer'));
    }

    public function test_registers_blade_component_and_view_namespace(): void
    {
        $aliases = $this->app->make('blade.compiler')->getClassComponentAliases();

        $this->assertArrayHasKey('w4-render', $aliases);
        $this->assertSame(Render::class, $aliases['w4-render']);
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.ui.button'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.ui.divider'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.ui.heading'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.ui.icon'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.ui.icon-button'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.ui.label'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.ui.link'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.ui.text'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.forms.checkbox'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.forms.field-error'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.forms.helper-text'));
        $this->assertTrue($this->app->make('view')->exists('w4-ui::components.forms.input'));
    }

    public function test_registers_blade_component_with_custom_prefix_from_config(): void
    {
        config()->set('w4-ui-framework.w4_ui_component_prefix', 'admin');

        $provider = new W4UiFrameworkServiceProvider($this->app);
        $provider->boot();

        $aliases = $this->app->make('blade.compiler')->getClassComponentAliases();

        $this->assertArrayHasKey('admin-render', $aliases);
        $this->assertSame(Render::class, $aliases['admin-render']);
        $this->assertArrayHasKey('admin-button', $aliases);
        $this->assertArrayHasKey('admin-divider', $aliases);
        $this->assertArrayHasKey('admin-heading', $aliases);
        $this->assertArrayHasKey('admin-icon', $aliases);
        $this->assertArrayHasKey('admin-icon-button', $aliases);
        $this->assertArrayHasKey('admin-label', $aliases);
        $this->assertArrayHasKey('admin-link', $aliases);
        $this->assertArrayHasKey('admin-text', $aliases);
        $this->assertArrayHasKey('admin-checkbox', $aliases);
        $this->assertArrayHasKey('admin-field-error', $aliases);
        $this->assertArrayHasKey('admin-helper-text', $aliases);
        $this->assertArrayHasKey('admin-input', $aliases);
    }

    public function test_registers_blade_component_with_custom_prefix_from_dashed_config_key(): void
    {
        config()->set('w4-ui-framework.w4_ui_component_prefix', 'w4');

        $provider = new W4UiFrameworkServiceProvider($this->app);
        $provider->boot();

        $aliases = $this->app->make('blade.compiler')->getClassComponentAliases();

        $this->assertArrayHasKey('w4-render', $aliases);
        $this->assertArrayHasKey('w4-button', $aliases);
        $this->assertArrayHasKey('w4-divider', $aliases);
        $this->assertArrayHasKey('w4-heading', $aliases);
        $this->assertArrayHasKey('w4-icon', $aliases);
        $this->assertArrayHasKey('w4-icon-button', $aliases);
        $this->assertArrayHasKey('w4-label', $aliases);
        $this->assertArrayHasKey('w4-link', $aliases);
        $this->assertArrayHasKey('w4-text', $aliases);
        $this->assertArrayHasKey('w4-checkbox', $aliases);
        $this->assertArrayHasKey('w4-field-error', $aliases);
        $this->assertArrayHasKey('w4-helper-text', $aliases);
        $this->assertArrayHasKey('w4-input', $aliases);
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

    public function test_publishes_log_stub_file_to_storage_logs_target(): void
    {
        $publishes = W4UiFrameworkServiceProvider::pathsToPublish(
            W4UiFrameworkServiceProvider::class,
            'w4-ui-log'
        );

        $this->assertIsArray($publishes);
        $this->assertContains(storage_path('logs/w4.ui.log'), array_values($publishes));

        $sources = array_keys($publishes);
        $matchedSource = collect($sources)->first(function (string $source) {
            $normalized = str_replace('\\', '/', $source);

            return str_ends_with($normalized, '/stub/w4.ui.log');
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

        $bladeCheckbox = new CheckBoxBladeComponent(
            label: 'Acepto términos',
            componentId: 'audit-checkbox-01'
        );

        $checkboxPayload = $this->app->make('w4.ui')->payload($bladeCheckbox->component());

        $this->assertSame('audit-checkbox-01', $checkboxPayload['data']['meta']['component_id']);
        $this->assertSame('audit-checkbox-01', $checkboxPayload['data']['attributes']['data-component-id']);

        $bladeFieldError = new FieldErrorBladeComponent(
            message: 'Campo requerido',
            componentId: 'audit-field-error-01'
        );

        $fieldErrorPayload = $this->app->make('w4.ui')->payload($bladeFieldError->component());

        $this->assertSame('audit-field-error-01', $fieldErrorPayload['data']['meta']['component_id']);
        $this->assertSame('audit-field-error-01', $fieldErrorPayload['data']['attributes']['data-component-id']);

        $bladeHelperText = new HelperTextBladeComponent(
            text: 'Puedes usar 8+ caracteres',
            componentId: 'audit-helper-text-01'
        );

        $helperTextPayload = $this->app->make('w4.ui')->payload($bladeHelperText->component());

        $this->assertSame('audit-helper-text-01', $helperTextPayload['data']['meta']['component_id']);
        $this->assertSame('audit-helper-text-01', $helperTextPayload['data']['attributes']['data-component-id']);
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

    public function test_logs_component_debug_when_w4_ui_log_is_enabled_and_component_has_data_component_id(): void
    {
        config()->set('w4-ui-framework.w4_ui_log', true);
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
        $this->assertStringContainsString('w4_ui.component_log', $logContent);
        $this->assertStringContainsString('"origin":"payload"', $logContent);
        $this->assertStringContainsString('"component":"button"', $logContent);
        $this->assertStringContainsString('"component_id":12547', $logContent);
        $this->assertStringContainsString('"dom_component_id":"12547"', $logContent);
        $this->assertStringContainsString('"state":"active"', $logContent);

        $metaOnlyButton = Button::make('Meta only')
            ->theme('daisyui')
            ->meta('component_id', 99001);

        $this->app->make('w4.ui')->payload($metaOnlyButton);

        $logContentAfterMetaOnly = file_get_contents($logPath);
        $this->assertIsString($logContentAfterMetaOnly);
        $this->assertStringContainsString('"component_id":99001', $logContentAfterMetaOnly);
        $this->assertStringContainsString('"dom_component_id":"99001"', $logContentAfterMetaOnly);
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

    public function test_blade_divider_maps_props_to_state_and_theme_payload(): void
    {
        $bladeDivider = new DividerBladeComponent(
            text: 'Sección',
            theme: 'daisyui',
            variant: 'primary',
            orientation: 'vertical',
            active: true,
            componentId: 'divider-audit-01'
        );

        $payload = $this->app->make('w4.ui')->payload($bladeDivider->component());

        $this->assertSame('divider', $payload['component']);
        $this->assertSame('active', $payload['data']['state']);
        $this->assertSame('vertical', $payload['data']['orientation']);
        $this->assertSame('divider-audit-01', $payload['data']['meta']['component_id']);
        $this->assertSame('divider-audit-01', $payload['data']['attributes']['data-component-id']);
        $this->assertStringContainsString('divider', $payload['theme']['classes']['root']);
        $this->assertStringContainsString('divider-horizontal', $payload['theme']['classes']['root']);
        $this->assertStringContainsString('divider-primary', $payload['theme']['classes']['root']);
        $this->assertSame('separator', $payload['theme']['attributes']['role']);
        $this->assertSame('vertical', $payload['theme']['attributes']['aria-orientation']);
    }

    public function test_blade_heading_maps_props_to_state_and_theme_payload(): void
    {
        $bladeHeading = new HeadingBladeComponent(
            text: 'Título principal',
            theme: 'tailwind',
            level: 'h1',
            variant: 'primary',
            active: true,
            componentId: 'heading-audit-01'
        );

        $payload = $this->app->make('w4.ui')->payload($bladeHeading->component());

        $this->assertSame('heading', $payload['component']);
        $this->assertSame('active', $payload['data']['state']);
        $this->assertSame('h1', $payload['data']['level']);
        $this->assertSame('heading-audit-01', $payload['data']['meta']['component_id']);
        $this->assertSame('heading-audit-01', $payload['data']['attributes']['data-component-id']);
        $this->assertStringContainsString('text-blue-600', $payload['theme']['classes']['root']);
        $this->assertStringContainsString('text-3xl', $payload['theme']['classes']['root']);
        $this->assertSame('heading', $payload['theme']['attributes']['role']);
        $this->assertSame(1, $payload['theme']['attributes']['aria-level']);
    }

    public function test_heading_level_changes_default_size_but_explicit_size_has_priority(): void
    {
        $autoSizePayload = $this->app->make('w4.ui')->payload(
            Heading::make('Título')
                ->theme('tailwind')
                ->level('h3')
                ->variant('primary')
        );

        $explicitSizePayload = $this->app->make('w4.ui')->payload(
            Heading::make('Título')
                ->theme('tailwind')
                ->level('h1')
                ->size('sm')
                ->variant('primary')
        );

        $this->assertStringContainsString('text-base', $autoSizePayload['theme']['classes']['root']);
        $this->assertStringNotContainsString('text-3xl', $autoSizePayload['theme']['classes']['root']);
        $this->assertStringContainsString('text-base', $explicitSizePayload['theme']['classes']['root']);
        $this->assertStringNotContainsString('text-3xl', $explicitSizePayload['theme']['classes']['root']);
    }

    public function test_daisy_heading_xl_is_larger_than_lg_scale_mapping(): void
    {
        $lgPayload = $this->app->make('w4.ui')->payload(
            Heading::make('Título')
                ->theme('daisyui')
                ->size('lg')
        );

        $xlPayload = $this->app->make('w4.ui')->payload(
            Heading::make('Título')
                ->theme('daisyui')
                ->size('xl')
        );

        $this->assertStringContainsString('text-xl', $lgPayload['theme']['classes']['root']);
        $this->assertStringContainsString('text-2xl', $xlPayload['theme']['classes']['root']);
    }

    public function test_blade_icon_maps_props_to_state_and_theme_payload(): void
    {
        $bladeIcon = new IconBladeComponent(
            label: 'Actualizar',
            icon: 'heroicon-o-arrow-path',
            theme: 'tailwind',
            variant: 'primary',
            size: 'lg',
            spin: true,
            active: true,
            componentId: 'icon-audit-01'
        );

        $payload = $this->app->make('w4.ui')->payload($bladeIcon->component());

        $this->assertSame('icon', $payload['component']);
        $this->assertSame('active', $payload['data']['state']);
        $this->assertSame('heroicon-o-arrow-path', $payload['data']['icon']);
        $this->assertTrue($payload['data']['spin']);
        $this->assertSame('icon-audit-01', $payload['data']['meta']['component_id']);
        $this->assertSame('icon-audit-01', $payload['data']['attributes']['data-component-id']);
        $this->assertStringContainsString('text-blue-600', $payload['theme']['classes']['root']);
        $this->assertStringContainsString('animate-spin', $payload['theme']['classes']['root']);
        $this->assertSame('img', $payload['theme']['attributes']['role']);
        $this->assertSame('false', $payload['theme']['attributes']['aria-hidden']);
    }

    public function test_blade_icon_button_maps_props_to_state_and_theme_payload(): void
    {
        $bladeIconButton = new IconButtonBladeComponent(
            label: 'Actualizar',
            icon: 'heroicon-o-arrow-path',
            theme: 'tailwind',
            variant: 'primary',
            size: 'lg',
            active: true,
            componentId: 'icon-button-audit-01'
        );

        $payload = $this->app->make('w4.ui')->payload($bladeIconButton->component());

        $this->assertSame('icon-button', $payload['component']);
        $this->assertSame('active', $payload['data']['state']);
        $this->assertSame('heroicon-o-arrow-path', $payload['data']['icon']);
        $this->assertSame('icon-button-audit-01', $payload['data']['meta']['component_id']);
        $this->assertSame('icon-button-audit-01', $payload['data']['attributes']['data-component-id']);
        $this->assertStringContainsString('bg-blue-600', $payload['theme']['classes']['root']);
        $this->assertStringContainsString('ring-2', $payload['theme']['classes']['root']);
        $this->assertSame('true', $payload['theme']['attributes']['aria-pressed']);
    }

    public function test_blade_label_maps_props_to_state_and_theme_payload(): void
    {
        $bladeLabel = new LabelBladeComponent(
            label: 'Correo',
            text: 'Correo electrónico',
            for: 'email',
            theme: 'tailwind',
            variant: 'primary',
            size: 'lg',
            active: true,
            componentId: 'label-audit-01'
        );

        $payload = $this->app->make('w4.ui')->payload($bladeLabel->component());

        $this->assertSame('label', $payload['component']);
        $this->assertSame('active', $payload['data']['state']);
        $this->assertSame('Correo electrónico', $payload['data']['text']);
        $this->assertSame('email', $payload['data']['for']);
        $this->assertSame('label-audit-01', $payload['data']['meta']['component_id']);
        $this->assertSame('label-audit-01', $payload['data']['attributes']['data-component-id']);
        $this->assertStringContainsString('text-blue-600', $payload['theme']['classes']['root']);
        $this->assertStringContainsString('underline', $payload['theme']['classes']['root']);
        $this->assertSame('email', $payload['theme']['attributes']['for']);
        $this->assertSame('false', $payload['theme']['attributes']['aria-hidden']);
    }

    public function test_blade_link_maps_props_to_state_and_theme_payload(): void
    {
        $bladeLink = new LinkBladeComponent(
            label: 'Documentación',
            text: 'Ir a docs',
            href: 'https://w4.software',
            target: '_blank',
            rel: 'noopener',
            theme: 'tailwind',
            variant: 'primary',
            size: 'lg',
            active: true,
            componentId: 'link-audit-01'
        );

        $payload = $this->app->make('w4.ui')->payload($bladeLink->component());

        $this->assertSame('link', $payload['component']);
        $this->assertSame('active', $payload['data']['state']);
        $this->assertSame('Ir a docs', $payload['data']['text']);
        $this->assertSame('https://w4.software', $payload['data']['href']);
        $this->assertSame('_blank', $payload['data']['target']);
        $this->assertSame('noopener', $payload['data']['rel']);
        $this->assertSame('link-audit-01', $payload['data']['meta']['component_id']);
        $this->assertSame('link-audit-01', $payload['data']['attributes']['data-component-id']);
        $this->assertStringContainsString('text-blue-600', $payload['theme']['classes']['root']);
        $this->assertStringContainsString('font-semibold', $payload['theme']['classes']['root']);
        $this->assertSame('https://w4.software', $payload['theme']['attributes']['href']);
        $this->assertSame('false', $payload['theme']['attributes']['aria-disabled']);
    }

    public function test_blade_text_maps_props_to_state_and_theme_payload(): void
    {
        $bladeText = new TextBladeComponent(
            label: 'Estado',
            text: 'Estado activo',
            theme: 'tailwind',
            variant: 'primary',
            size: 'lg',
            active: true,
            componentId: 'text-audit-01'
        );

        $payload = $this->app->make('w4.ui')->payload($bladeText->component());

        $this->assertSame('text', $payload['component']);
        $this->assertSame('active', $payload['data']['state']);
        $this->assertSame('Estado activo', $payload['data']['text']);
        $this->assertSame('text-audit-01', $payload['data']['meta']['component_id']);
        $this->assertSame('text-audit-01', $payload['data']['attributes']['data-component-id']);
        $this->assertStringContainsString('text-blue-600', $payload['theme']['classes']['root']);
        $this->assertStringContainsString('font-semibold', $payload['theme']['classes']['root']);
        $this->assertSame('text', $payload['theme']['attributes']['role']);
        $this->assertSame('false', $payload['theme']['attributes']['aria-hidden']);
    }

    public function test_blade_checkbox_maps_props_to_state_and_theme_payload(): void
    {
        $bladeCheckbox = new CheckBoxBladeComponent(
            label: 'Acepto términos',
            theme: 'tailwind',
            variant: 'primary',
            size: 'md',
            checked: true,
            invalid: true,
            focused: true,
            componentId: 'checkbox-audit-01'
        );

        $payload = $this->app->make('w4.ui')->payload($bladeCheckbox->component());

        $this->assertSame('checkbox', $payload['component']);
        $this->assertSame('invalid', $payload['data']['state']);
        $this->assertTrue($payload['data']['checked']);
        $this->assertFalse($payload['data']['indeterminate']);
        $this->assertSame('checkbox-audit-01', $payload['data']['meta']['component_id']);
        $this->assertSame('checkbox-audit-01', $payload['data']['attributes']['data-component-id']);
        $this->assertStringContainsString('border-rose-500', $payload['theme']['classes']['input']);
        $this->assertSame('true', $payload['theme']['attributes']['aria-invalid']);
        $this->assertSame('true', $payload['theme']['attributes']['aria-checked']);
        $this->assertSame('true', $payload['theme']['attributes']['data-focused']);
    }

    public function test_blade_field_error_maps_props_to_state_and_theme_payload(): void
    {
        $bladeFieldError = new FieldErrorBladeComponent(
            message: 'Campo requerido',
            code: 'E_REQUIRED',
            hint: 'Revisa este campo',
            forField: 'email',
            theme: 'tailwind',
            variant: 'error',
            active: true,
            componentId: 'field-error-audit-01'
        );

        $payload = $this->app->make('w4.ui')->payload($bladeFieldError->component());

        $this->assertSame('field-error', $payload['component']);
        $this->assertSame('active', $payload['data']['state']);
        $this->assertSame('Campo requerido', $payload['data']['message']);
        $this->assertSame('E_REQUIRED', $payload['data']['code']);
        $this->assertSame('Revisa este campo', $payload['data']['hint']);
        $this->assertSame('field-error-audit-01', $payload['data']['meta']['component_id']);
        $this->assertSame('field-error-audit-01', $payload['data']['attributes']['data-component-id']);
        $this->assertSame('assertive', $payload['theme']['attributes']['aria-live']);
        $this->assertSame('email', $payload['theme']['attributes']['data-for-field']);
        $this->assertSame('E_REQUIRED', $payload['theme']['attributes']['data-error-code']);
    }

    public function test_blade_helper_text_maps_props_to_state_and_theme_payload(): void
    {
        $bladeHelperText = new HelperTextBladeComponent(
            text: 'Puedes usar 8+ caracteres',
            icon: 'ℹ',
            forField: 'password',
            theme: 'tailwind',
            variant: 'info',
            active: true,
            focused: true,
            componentId: 'helper-text-audit-01'
        );

        $payload = $this->app->make('w4.ui')->payload($bladeHelperText->component());

        $this->assertSame('helper-text', $payload['component']);
        $this->assertSame('active', $payload['data']['state']);
        $this->assertSame('Puedes usar 8+ caracteres', $payload['data']['text']);
        $this->assertSame('ℹ', $payload['data']['icon']);
        $this->assertSame('helper-text-audit-01', $payload['data']['meta']['component_id']);
        $this->assertSame('helper-text-audit-01', $payload['data']['attributes']['data-component-id']);
        $this->assertStringContainsString('text-cyan-600', $payload['theme']['classes']['root']);
        $this->assertStringContainsString('font-medium', $payload['theme']['classes']['root']);
        $this->assertSame('note', $payload['theme']['attributes']['role']);
        $this->assertSame('polite', $payload['theme']['attributes']['aria-live']);
        $this->assertSame('password', $payload['theme']['attributes']['data-for-field']);
        $this->assertSame('true', $payload['theme']['attributes']['data-focused']);
    }

    public function test_icon_button_resolves_classes_for_daisyui_bootstrap_and_tailwind(): void
    {
        $daisyPayload = $this->app->make('w4.ui')->payload(
            IconButton::make('Actualizar')
                ->icon('heroicon-o-arrow-path')
                ->theme('daisyui')
                ->variant('primary')
        );

        $bootstrapPayload = $this->app->make('w4.ui')->payload(
            IconButton::make('Actualizar')
                ->icon('heroicon-o-arrow-path')
                ->theme('bootstrap')
                ->variant('primary')
        );

        $tailwindPayload = $this->app->make('w4.ui')->payload(
            IconButton::make('Actualizar')
                ->icon('heroicon-o-arrow-path')
                ->theme('tailwind')
                ->variant('primary')
        );

        $this->assertStringContainsString('btn-square', $daisyPayload['theme']['classes']['root']);
        $this->assertStringContainsString('btn-primary', $daisyPayload['theme']['classes']['root']);
        $this->assertSame('Actualizar', $daisyPayload['theme']['attributes']['aria-label']);

        $this->assertStringContainsString('btn', $bootstrapPayload['theme']['classes']['root']);
        $this->assertStringContainsString('btn-primary', $bootstrapPayload['theme']['classes']['root']);
        $this->assertSame('Actualizar', $bootstrapPayload['theme']['attributes']['aria-label']);

        $this->assertStringContainsString('inline-flex', $tailwindPayload['theme']['classes']['root']);
        $this->assertStringContainsString('bg-blue-600', $tailwindPayload['theme']['classes']['root']);
        $this->assertSame('Actualizar', $tailwindPayload['theme']['attributes']['aria-label']);
    }

    public function test_label_resolves_classes_for_daisyui_bootstrap_and_tailwind(): void
    {
        $daisyPayload = $this->app->make('w4.ui')->payload(
            Label::make('Correo')
                ->text('Correo electrónico')
                ->for('email')
                ->theme('daisyui')
                ->variant('primary')
        );

        $bootstrapPayload = $this->app->make('w4.ui')->payload(
            Label::make('Correo')
                ->text('Correo electrónico')
                ->for('email')
                ->theme('bootstrap')
                ->variant('primary')
        );

        $tailwindPayload = $this->app->make('w4.ui')->payload(
            Label::make('Correo')
                ->text('Correo electrónico')
                ->for('email')
                ->theme('tailwind')
                ->variant('primary')
        );

        $this->assertStringContainsString('label', $daisyPayload['theme']['classes']['root']);
        $this->assertStringContainsString('text-primary', $daisyPayload['theme']['classes']['root']);
        $this->assertSame('email', $daisyPayload['theme']['attributes']['for']);

        $this->assertStringContainsString('form-label', $bootstrapPayload['theme']['classes']['root']);
        $this->assertStringContainsString('text-primary', $bootstrapPayload['theme']['classes']['root']);
        $this->assertSame('email', $bootstrapPayload['theme']['attributes']['for']);

        $this->assertStringContainsString('inline-block', $tailwindPayload['theme']['classes']['root']);
        $this->assertStringContainsString('text-blue-600', $tailwindPayload['theme']['classes']['root']);
        $this->assertSame('email', $tailwindPayload['theme']['attributes']['for']);
    }

    public function test_link_resolves_classes_for_daisyui_bootstrap_and_tailwind(): void
    {
        $daisyPayload = $this->app->make('w4.ui')->payload(
            Link::make('Documentación')
                ->text('Ver docs')
                ->href('https://w4.software')
                ->theme('daisyui')
                ->variant('primary')
        );

        $bootstrapPayload = $this->app->make('w4.ui')->payload(
            Link::make('Documentación')
                ->text('Ver docs')
                ->href('https://w4.software')
                ->theme('bootstrap')
                ->variant('primary')
        );

        $tailwindPayload = $this->app->make('w4.ui')->payload(
            Link::make('Documentación')
                ->text('Ver docs')
                ->href('https://w4.software')
                ->theme('tailwind')
                ->variant('primary')
        );

        $this->assertStringContainsString('link', $daisyPayload['theme']['classes']['root']);
        $this->assertStringContainsString('link-primary', $daisyPayload['theme']['classes']['root']);
        $this->assertSame('https://w4.software', $daisyPayload['theme']['attributes']['href']);

        $this->assertStringContainsString('link-primary', $bootstrapPayload['theme']['classes']['root']);
        $this->assertStringContainsString('fs-4', $bootstrapPayload['theme']['classes']['root']);
        $this->assertSame('https://w4.software', $bootstrapPayload['theme']['attributes']['href']);

        $this->assertStringContainsString('text-blue-600', $tailwindPayload['theme']['classes']['root']);
        $this->assertStringContainsString('underline', $tailwindPayload['theme']['classes']['root']);
        $this->assertSame('https://w4.software', $tailwindPayload['theme']['attributes']['href']);
    }

    public function test_text_resolves_classes_for_daisyui_bootstrap_and_tailwind(): void
    {
        $daisyPayload = $this->app->make('w4.ui')->payload(
            Text::make('Estado')
                ->text('Estado activo')
                ->theme('daisyui')
                ->variant('primary')
        );

        $bootstrapPayload = $this->app->make('w4.ui')->payload(
            Text::make('Estado')
                ->text('Estado activo')
                ->theme('bootstrap')
                ->variant('primary')
        );

        $tailwindPayload = $this->app->make('w4.ui')->payload(
            Text::make('Estado')
                ->text('Estado activo')
                ->theme('tailwind')
                ->variant('primary')
        );

        $this->assertStringContainsString('text-primary', $daisyPayload['theme']['classes']['root']);
        $this->assertStringContainsString('text-base', $daisyPayload['theme']['classes']['root']);
        $this->assertSame('text', $daisyPayload['theme']['attributes']['role']);

        $this->assertStringContainsString('text-primary', $bootstrapPayload['theme']['classes']['root']);
        $this->assertStringContainsString('fs-4', $bootstrapPayload['theme']['classes']['root']);
        $this->assertSame('text', $bootstrapPayload['theme']['attributes']['role']);

        $this->assertStringContainsString('text-blue-600', $tailwindPayload['theme']['classes']['root']);
        $this->assertStringContainsString('text-base', $tailwindPayload['theme']['classes']['root']);
        $this->assertSame('text', $tailwindPayload['theme']['attributes']['role']);
    }

    public function test_checkbox_resolves_classes_for_daisyui_bootstrap_and_tailwind(): void
    {
        $daisyPayload = $this->app->make('w4.ui')->payload(
            CheckBox::make('Acepto términos')
                ->theme('daisyui')
                ->variant('primary')
                ->checked(true)
        );

        $bootstrapPayload = $this->app->make('w4.ui')->payload(
            CheckBox::make('Acepto términos')
                ->theme('bootstrap')
                ->variant('primary')
                ->checked(true)
        );

        $tailwindPayload = $this->app->make('w4.ui')->payload(
            CheckBox::make('Acepto términos')
                ->theme('tailwind')
                ->variant('primary')
                ->checked(true)
        );

        $this->assertStringContainsString('checkbox-primary', $daisyPayload['theme']['classes']['input']);
        $this->assertSame('true', $daisyPayload['theme']['attributes']['aria-checked']);

        $this->assertStringContainsString('form-check-input', $bootstrapPayload['theme']['classes']['input']);
        $this->assertSame('true', $bootstrapPayload['theme']['attributes']['aria-checked']);

        $this->assertStringContainsString('text-blue-600', $tailwindPayload['theme']['classes']['input']);
        $this->assertStringContainsString('border-blue-400', $tailwindPayload['theme']['classes']['input']);
        $this->assertSame('true', $tailwindPayload['theme']['attributes']['aria-checked']);
    }

    public function test_field_error_resolves_classes_for_daisyui_bootstrap_and_tailwind(): void
    {
        $daisyPayload = $this->app->make('w4.ui')->payload(
            FieldError::make('Campo requerido')
                ->theme('daisyui')
                ->variant('error')
                ->activate()
        );

        $bootstrapPayload = $this->app->make('w4.ui')->payload(
            FieldError::make('Campo requerido')
                ->theme('bootstrap')
                ->variant('error')
                ->activate()
        );

        $tailwindPayload = $this->app->make('w4.ui')->payload(
            FieldError::make('Campo requerido')
                ->theme('tailwind')
                ->variant('error')
                ->activate()
        );

        $this->assertStringContainsString('text-error', $daisyPayload['theme']['classes']['root']);
        $this->assertSame('assertive', $daisyPayload['theme']['attributes']['aria-live']);

        $this->assertStringContainsString('invalid-feedback', $bootstrapPayload['theme']['classes']['root']);
        $this->assertStringContainsString('text-danger', $bootstrapPayload['theme']['classes']['root']);
        $this->assertSame('assertive', $bootstrapPayload['theme']['attributes']['aria-live']);

        $this->assertStringContainsString('text-rose-600', $tailwindPayload['theme']['classes']['root']);
        $this->assertSame('assertive', $tailwindPayload['theme']['attributes']['aria-live']);
    }

    public function test_helper_text_resolves_classes_for_daisyui_bootstrap_and_tailwind(): void
    {
        $daisyPayload = $this->app->make('w4.ui')->payload(
            HelperText::make('Ayuda')
                ->theme('daisyui')
                ->variant('info')
                ->activate()
        );

        $bootstrapPayload = $this->app->make('w4.ui')->payload(
            HelperText::make('Ayuda')
                ->theme('bootstrap')
                ->variant('info')
                ->activate()
        );

        $tailwindPayload = $this->app->make('w4.ui')->payload(
            HelperText::make('Ayuda')
                ->theme('tailwind')
                ->variant('info')
                ->activate()
        );

        $this->assertStringContainsString('label-text-alt', $daisyPayload['theme']['classes']['root']);
        $this->assertStringContainsString('text-info', $daisyPayload['theme']['classes']['root']);
        $this->assertSame('polite', $daisyPayload['theme']['attributes']['aria-live']);

        $this->assertStringContainsString('form-text', $bootstrapPayload['theme']['classes']['root']);
        $this->assertStringContainsString('text-info', $bootstrapPayload['theme']['classes']['root']);
        $this->assertSame('polite', $bootstrapPayload['theme']['attributes']['aria-live']);

        $this->assertStringContainsString('text-cyan-600', $tailwindPayload['theme']['classes']['root']);
        $this->assertStringContainsString('font-medium', $tailwindPayload['theme']['classes']['root']);
        $this->assertSame('polite', $tailwindPayload['theme']['attributes']['aria-live']);
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

        $dividerResolver = new TailwindDividerThemeResolver();
        $dividerClasses = $dividerResolver->classes([
            'variant' => 'primary',
            'size' => 'md',
            'orientation' => 'horizontal',
            'attributes' => ['class' => 'mt-6'],
        ]);

        $this->assertStringContainsString('before:border-blue-500', $dividerClasses['root']);
        $this->assertStringContainsString('after:border-blue-500', $dividerClasses['root']);
        $this->assertStringContainsString('before:border-t-2', $dividerClasses['root']);
        $this->assertStringContainsString('after:border-t-2', $dividerClasses['root']);
        $this->assertStringContainsString('mt-6', $dividerClasses['root']);

        $headingResolver = new TailwindHeadingThemeResolver();
        $headingClasses = $headingResolver->classes([
            'variant' => 'primary',
            'size' => 'lg',
            'attributes' => ['class' => 'mt-6'],
        ]);

        $this->assertStringContainsString('text-blue-600', $headingClasses['root']);
        $this->assertStringContainsString('text-2xl', $headingClasses['root']);
        $this->assertStringContainsString('mt-6', $headingClasses['root']);

        $iconResolver = new TailwindIconThemeResolver();
        $iconClasses = $iconResolver->classes([
            'variant' => 'primary',
            'size' => 'lg',
            'spin' => true,
            'attributes' => ['class' => 'mt-2'],
        ]);

        $this->assertStringContainsString('text-blue-600', $iconClasses['root']);
        $this->assertStringContainsString('text-lg', $iconClasses['root']);
        $this->assertStringContainsString('animate-spin', $iconClasses['root']);
        $this->assertStringContainsString('mt-2', $iconClasses['root']);

        $iconButtonResolver = new TailwindIconButtonThemeResolver();
        $iconButtonClasses = $iconButtonResolver->classes([
            'variant' => 'primary',
            'size' => 'sm',
            'attributes' => ['class' => 'h-14 w-14'],
        ]);

        $this->assertStringContainsString('bg-blue-600', $iconButtonClasses['root']);
        $this->assertStringContainsString('h-14', $iconButtonClasses['root']);
        $this->assertStringContainsString('w-14', $iconButtonClasses['root']);
        $this->assertStringNotContainsString('h-8', $iconButtonClasses['root']);

        $labelResolver = new TailwindLabelThemeResolver();
        $labelClasses = $labelResolver->classes([
            'variant' => 'primary',
            'size' => 'sm',
            'attributes' => ['class' => 'mt-2'],
        ]);

        $this->assertStringContainsString('text-blue-600', $labelClasses['root']);
        $this->assertStringContainsString('text-sm', $labelClasses['root']);
        $this->assertStringContainsString('mt-2', $labelClasses['root']);

        $linkResolver = new TailwindLinkThemeResolver();
        $linkClasses = $linkResolver->classes([
            'variant' => 'primary',
            'size' => 'sm',
            'attributes' => ['class' => 'mt-2'],
        ]);

        $this->assertStringContainsString('text-blue-600', $linkClasses['root']);
        $this->assertStringContainsString('text-sm', $linkClasses['root']);
        $this->assertStringContainsString('mt-2', $linkClasses['root']);

        $textResolver = new TailwindTextThemeResolver();
        $textClasses = $textResolver->classes([
            'variant' => 'primary',
            'size' => 'sm',
            'attributes' => ['class' => 'mt-2'],
        ]);

        $this->assertStringContainsString('text-blue-600', $textClasses['root']);
        $this->assertStringContainsString('text-sm', $textClasses['root']);
        $this->assertStringContainsString('mt-2', $textClasses['root']);

        $helperTextResolver = new TailwindHelperTextThemeResolver();
        $helperTextClasses = $helperTextResolver->classes([
            'variant' => 'primary',
            'size' => 'sm',
            'attributes' => ['class' => 'mt-2'],
        ]);

        $this->assertStringContainsString('text-blue-600', $helperTextClasses['root']);
        $this->assertStringContainsString('text-sm', $helperTextClasses['root']);
        $this->assertStringContainsString('mt-2', $helperTextClasses['root']);
    }
}
