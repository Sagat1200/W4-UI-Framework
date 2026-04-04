# 🚀 W4-UI-Framework

## ✨ Contexto del componente Bootstrap Heading

## 1. 📌 Información General

`Bootstrap Heading` usa:

- componente base `W4\UiFramework\Components\UI\Heading\Heading`
- resolver `W4\UiFramework\Themes\Bootstrap\Components\UI\HeadingThemeResolver`

## 2. 🧱 API base del Heading (heredada)

```php
use W4\UiFramework\Components\UI\Heading\Heading;

$heading = Heading::make('Perfil')
    ->theme('bootstrap')
    ->text('Configuración de perfil')
    ->level('h2')
    ->variant('primary')
    ->size('lg');
```

Fluent API más usada:

```php
$heading = Heading::make('Perfil')
    ->name('profile_title')
    ->id('heading-profile')
    ->theme('bootstrap')
    ->level('h2')
    ->variant('primary')
    ->size('lg');
```

Estados:

- `enabled`
- `disabled`
- `active`
- `hidden`

Eventos:

- `activate`
- `deactivate`
- `disable`
- `enable`
- `hide`
- `show`
- `reset`

## 3. 🎨 Resolución visual Bootstrap (ThemeResolver)

Base:

- `fw-semibold`

### 3.1 Variantes disponibles

- `text-primary`, `text-secondary`, `text-success`, `text-warning`, `text-danger`, `text-info`, `text-light`, `text-dark`

### 3.2 Tamaños disponibles

- `xs -> fs-6`
- `sm -> fs-5`
- `md -> fs-4`
- `lg -> fs-3`
- `xl -> fs-2`

### 3.3 Estados y clases adicionales

- base: `fw-semibold`
- `state=disabled` agrega `opacity-50`
- `state=active` agrega `text-decoration-underline`
- `state=hidden` agrega `d-none`
- `class` del usuario se mergea con las clases resueltas

### 3.4 Atributos HTML resueltos

- `role="heading"`
- `aria-level`
- `aria-hidden`
- `data-state`

## 4. 🖥️ Formas de renderizar Bootstrap Heading

Nota de uso de tema:

- Usa `theme="bootstrap"` en Blade cuando el tema global no sea Bootstrap.
- Usa `->theme('bootstrap')` en helper/facade para forzar Bootstrap en esa instancia.

### 4.1 Helper

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Heading\Heading::make('Resumen')
        ->theme('bootstrap')
        ->level('h2')
        ->variant('secondary')
        ->size('md')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Heading\Heading;

echo W4Ui::render(
    Heading::make('Panel')
        ->theme('bootstrap')
        ->level('h3')
        ->variant('info')
);
```

### 4.3 Componente Blade directo (`x-w4-heading`)

```blade
<x-w4-heading
    theme="bootstrap"
    text="Título de módulo"
    level="h3"
    variant="primary"
    size="lg"
    class="mb-3"
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
        ->theme('bootstrap')
        ->dispatch(\W4\UiFramework\Components\UI\Heading\HeadingComponentEvent::ACTIVATE)
);
```

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Heading\Heading::make('Oculto')
        ->theme('bootstrap')
        ->dispatch(\W4\UiFramework\Components\UI\Heading\HeadingComponentEvent::HIDE)
);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-heading`)

```blade
<x-w4-heading text="Encabezado visible" theme="bootstrap" level="h2" />
<x-w4-heading text="Encabezado oculto" theme="bootstrap" level="h2" :hidden="true" />
```

## 5. 🧭 Ejemplos prácticos Bootstrap

Heading con `componentId` para auditoría/estado:

```blade
<x-w4-heading
    text="Título auditado"
    theme="bootstrap"
    :componentId="'heading-9001'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Heading\Heading::make('Título')
        ->theme('bootstrap')
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
        ->theme('bootstrap')
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
