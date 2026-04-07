# W4 UI Framework

Paquete de abstraccion y contruccion de componentes de usuario y gestor de temas para Laravel PHP.

## ¿Qué incluye?

- Registro de componentes por alias (`button`, `input`).
- Pipeline de renderizado (`theme resolver` + `renderer`).
- Temas incluidos:
  - `w4native`
- Renderer incluido:
  - `blade`
- Helpers globales:
  - `w4_render(...)`
  - `w4_view(...)`
  - `w4_payload(...)`
- Componentes Blade:
  - `<x-w4-render />`
  - `<x-w4-button />`
  - `<x-w4-input />`

## Requisitos

- PHP `^8.3`
- Laravel `^13.0`

## Instalación

```bash
composer require w4/ui-framework
```

Publicar configuración:

```bash
php artisan vendor:publish --tag=w4-ui-config
```

## Configuración

Archivo: `config/w4-ui-framework.php`

```php
return [
    'theme' => env('W4_UI_THEME', 'w4native'),
    'renderer' => env('W4_UI_RENDERER', 'blade'),
];
```

Variables de entorno:

```env
W4_UI_THEME=w4native
W4_UI_RENDERER=blade
```

Tema soportado actualmente:

- `w4native`

## Uso rápido

### 1) Core component + helper

```php
use W4\UiFramework\Components\UI\Button\Button;

echo w4_render(
    Button::make('Guardar')
        ->theme('w4native')
        ->variant('primary')
);
```

### 2) Facade

```php
use W4\UiFramework\Components\Forms\Input\Input;
use W4\UiFramework\Facades\W4Ui;

echo W4Ui::render(
    Input::make('Correo')
        ->name('email')
        ->type('email')
        ->theme('w4native')
);
```

### 3) Blade components

```blade
<x-w4-button
    label="Guardar"
    variant="primary"
    theme="w4native"
/>

<x-w4-input
    label="Correo"
    name="email"
    type="email"
    placeholder="correo@dominio.com"
    theme="w4native"
/>
```

## API de salida

`w4_payload(...)` retorna una estructura normalizada para inspección o integración:

```php
[
  'renderer' => 'blade',
  'view' => 'w4-ui::components....',
  'component' => 'button|input',
  'data' => [...],
  'theme' => [
    'classes' => [...],
    'attributes' => [...],
  ],
]
```

## Estado y eventos

El paquete maneja estado por componente con state machine.

Ejemplo (Button):

```php
use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;

$button = Button::make('Enviar')
    ->dispatch(ButtonComponentEvent::START_LOADING);
```

Ejemplo (Input):

```php
use W4\UiFramework\Components\Forms\Input\Input;
use W4\UiFramework\Components\Forms\Input\InputComponentEvent;

$input = Input::make('Correo')
    ->dispatch(InputComponentEvent::SET_INVALID);
```

## Tema global vs tema por componente

- Si `W4_UI_THEME=w4native`, no necesitas definir `theme="w4native"` en cada componente.
- Define `theme` por componente cuando quieras forzar un tema puntual.

## Vistas Blade

El paquete carga vistas con namespace:

- `w4-ui::...`

Componentes y wrappers Blade registrados:

- `w4-render`
- `w4-button`
- `w4-input`

## Pruebas

```bash
composer test
```

## Estructura principal (referencia rápida)

- `src/Providers/W4UiFrameworkServiceProvider.php`
- `src/Support/W4UiManager.php`
- `src/Renderers/BladeRenderer.php`
- `src/Themes/W4Native/*`
- `src/View/Components/*`
- `src/Helpers/helpers.php`

## Licencia

MIT
