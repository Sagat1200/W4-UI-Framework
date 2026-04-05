# 🚀 W4-UI-Framework

## ✨ Contexto del componente Daisy Heading

## 1. 📌 Información General

`Daisy Heading` reutiliza el componente base:

`W4\UiFramework\Components\UI\Heading\Heading`

y aplica estilos/atributos a través del resolver:

`W4\UiFramework\Themes\DaisyUI\Components\UI\HeadingThemeResolver`

## 2. 🧱 API base del Heading (heredada)

Creación base:

```php
use W4\UiFramework\Components\UI\Heading\Heading;

$heading = Heading::make('Título');
```

Fluent API más usada:

```php
$heading = Heading::make('Título principal')
    ->name('page_title')
    ->id('heading-page-title')
    ->theme('daisyui')
    ->level('h2')
    ->variant('primary')
    ->size('lg');
```

Regla de tamaño y nivel:

- `level('h1'..'h6')` define la semántica del heading.
- Si no defines `size(...)`, el componente asigna tamaño por nivel:
  - `h1 -> xl`
  - `h2 -> md`
  - `h3 -> sm`
  - `h4/h5/h6 -> xs`
- Si defines `size(...)`, ese tamaño tiene prioridad sobre el mapeo automático por `level`.

Estados funcionales soportados:

- `enabled`
- `disabled`
- `active`
- `hidden`

Eventos soportados por la state machine:

- `activate`
- `deactivate`
- `disable`
- `enable`
- `hide`
- `show`
- `reset`

## 3. 🎨 Resolución visual DaisyUI (ThemeResolver)

### 3.1 Variantes disponibles

- `neutral` -> `text-base-content`
- `primary` -> `text-primary`
- `secondary` -> `text-secondary`
- `accent` -> `text-accent`
- `success` -> `text-success`
- `warning` -> `text-warning`
- `error` -> `text-error`
- `info` -> `text-info`

### 3.2 Tamaños disponibles

- `xs` -> `text-xs`
- `sm` -> `text-sm`
- `md` -> `text-base`
- `lg` -> `text-lg`
- `xl` -> `text-xl`

Relación con `level` cuando no hay `size(...)` explícito:

- `h1 -> xl`
- `h2 -> md`
- `h3 -> sm`
- `h4/h5/h6 -> xs`

### 3.3 Estados y clases adicionales

- base: `font-semibold leading-tight`
- `state=disabled` agrega `opacity-50`
- `state=active` agrega `underline`
- `state=hidden` agrega `hidden`
- `class` del usuario se mergea con las clases resueltas

### 3.4 Atributos HTML resueltos

- `role="heading"`
- `aria-level`
- `aria-hidden`
- `data-state`

## 4. 🖥️ Formas de renderizar Daisy Heading

Nota de uso de tema:

- Usa `theme="daisyui"` en `x-w4-heading` cuando el tema global no sea DaisyUI y quieras forzar Daisy en ese heading.
- Usa `->theme('daisyui')` en `Heading::make(...)` cuando renderizas por helper/facade y quieras forzar Daisy en esa instancia.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Heading\Heading::make('Dashboard')
        ->theme('daisyui')
        ->level('h1')
        ->variant('primary')
        ->size('xl')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Heading\Heading;

echo W4Ui::render(
    Heading::make('Resumen')
        ->theme('daisyui')
        ->level('h2')
        ->variant('accent')
);
```

### 4.3 Componente Blade directo (`x-w4-heading`)

```blade
<x-w4-heading
    theme="daisyui"
    text="Título de sección"
    level="h3"
    variant="info"
    size="md"
    class="mt-6"
/>
```

Parámetros Blade comunes:

- `label`
- `text`
- `id`
- `name`
- `theme`
- `renderer`
- `level`
- `variant`
- `size`
- `active`
- `disabled`
- `hidden`
- `focused`
- `hovered`
- `class`
- `componentId`

### 4.4 Ejemplos de renderizado por estado y evento

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Heading\Heading::make('Activo')
        ->theme('daisyui')
        ->dispatch(\W4\UiFramework\Components\UI\Heading\HeadingComponentEvent::ACTIVATE)
);
```

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Heading\Heading::make('Oculto')
        ->theme('daisyui')
        ->dispatch(\W4\UiFramework\Components\UI\Heading\HeadingComponentEvent::HIDE)
);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-heading`)

```blade
<x-w4-heading text="Encabezado visible" theme="daisyui" level="h2" />
<x-w4-heading text="Encabezado oculto" theme="daisyui" level="h2" :hidden="true" />
```

## 5. 🧭 Ejemplos prácticos Daisy

Heading con `componentId` para auditoría/estado:

```blade
<x-w4-heading
    text="Título auditado"
    theme="daisyui"
    :componentId="'heading-9001'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Heading\Heading::make('Título')
        ->theme('daisyui')
        ->meta('component_id', 'heading-9001')
        ->attribute('data-component-id', 'heading-9001')
);
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
use W4\UiFramework\Components\UI\Heading\Heading;
use W4\UiFramework\Facades\W4Ui;

public function index()
{
    $heading = Heading::make('Panel principal')
        ->theme('daisyui')
        ->level('h1')
        ->variant('primary');

    return view('dashboard.index', [
        'headingHtml' => W4Ui::render($heading),
    ]);
}
```

## 7. 📦 Notas de integración

- El heading usa el payload estándar (`renderer`, `view`, `data`, `theme`).
- Si `W4_UI_LOG=true`, se registra en `storage/logs/w4.ui.log`.
- Campos clave del log: `component`, `component_id`, `dom_component_id`, `state`, `view`.
