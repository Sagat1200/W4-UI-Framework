# 🚀 W4-UI-Framework

## ✨ Contexto del componente Daisy Divider

## 1. 📌 Información General

`Daisy Divider` reutiliza el componente base:

`W4\UiFramework\Components\UI\Divider\Divider`

y aplica estilos/atributos mediante:

`W4\UiFramework\Themes\DaisyUI\Components\UI\DividerThemeResolver`

## 2. 🧱 API base del Divider

Creación base:

```php
use W4\UiFramework\Components\UI\Divider\Divider;

$divider = Divider::make();
```

Fluent API común:

```php
$divider = Divider::make()
    ->id('div-main')
    ->name('section_divider')
    ->theme('daisyui')
    ->text('Información')
    ->variant('primary')
    ->size('md')
    ->orientation('horizontal');
```

Estados soportados:

- `enabled`
- `disabled`
- `active`
- `hidden`

Eventos soportados:

- `activate`
- `deactivate`
- `disable`
- `enable`
- `hide`
- `show`
- `reset`

## 3. 🎨 Resolución visual DaisyUI

Clase base:

- `divider`

Variantes (`variant`):

- `primary` -> `divider-primary`
- `secondary` -> `divider-secondary`
- `accent` -> `divider-accent`
- `success` -> `divider-success`
- `warning` -> `divider-warning`
- `error` -> `divider-error`
- `info` -> `divider-info`
- default -> `divider-neutral`

Orientación:

- `vertical` agrega `divider-horizontal` (comportamiento DaisyUI)
- `horizontal` mantiene layout por defecto

Estados visuales:

- `disabled` agrega `opacity-50`
- `active` agrega `font-semibold`
- `hidden` agrega `hidden`

Atributos resueltos:

- `role="separator"`
- `aria-orientation="horizontal|vertical"`
- `aria-hidden="true|false"`
- `data-state="..."`

## 4. 🖥️ Formas de renderizar Daisy Divider

Nota de uso de tema:

- Usa `theme="daisyui"` en `x-w4-divider` cuando el tema global de tu proyecto no sea DaisyUI.
- Usa `->theme('daisyui')` en `Divider::make(...)` al renderizar por helper/facade.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Divider\Divider::make()
        ->theme('daisyui')
        ->text('Detalle')
        ->variant('primary')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Divider\Divider;

echo W4Ui::render(
    Divider::make()
        ->theme('daisyui')
        ->text('Sección')
        ->variant('accent')
        ->orientation('vertical')
);
```

### 4.3 Componente Blade directo (`x-w4-divider`)

```blade
<x-w4-divider
    theme="daisyui"
    text="Sección"
    variant="primary"
    size="md"
    orientation="horizontal"
/>
```

Parámetros Blade comunes:

- `label`
- `text`
- `id`
- `name`
- `theme`
- `renderer`
- `variant`
- `size`
- `orientation`
- `active`
- `disabled`
- `hidden`
- `focused`
- `hovered`
- `class`

### 4.4 Equivalencias de render (helper vs facade vs blade)

Objetivo: mismo resultado visual y semántico en las 3 formas.

Helper:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Divider\Divider::make()
        ->theme('daisyui')
        ->text('Equivalente')
        ->variant('primary')
        ->size('md')
        ->orientation('horizontal')
);
```

Facade:

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Divider\Divider;

echo W4Ui::render(
    Divider::make()
        ->theme('daisyui')
        ->text('Equivalente')
        ->variant('primary')
        ->size('md')
        ->orientation('horizontal')
);
```

Blade:

```blade
<x-w4-divider
    theme="daisyui"
    text="Equivalente"
    variant="primary"
    size="md"
    orientation="horizontal"
/>
```

### 4.5 Ejemplos de `class` para orientación vertical (`h-*`, `w-*`)

Vertical con alto personalizado:

```blade
<x-w4-divider
    theme="daisyui"
    text="Timeline"
    orientation="vertical"
    class="h-40 my-4"
/>
```

Vertical con ancho personalizado:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Divider\Divider::make()
        ->theme('daisyui')
        ->text('Separador')
        ->orientation('vertical')
        ->attribute('class', 'w-2 h-32')
);
```

### 4.6 Ejemplos de renderizado por estado y evento

```php
use W4\UiFramework\Components\UI\Divider\Divider;
use W4\UiFramework\Components\UI\Divider\DividerComponentEvent;

echo w4_render(
    Divider::make()
        ->theme('daisyui')
        ->text('Proceso')
        ->dispatch(DividerComponentEvent::ACTIVATE)
);
```

```php
$divider = Divider::make()
    ->theme('daisyui')
    ->text('Oculto')
    ->dispatch(DividerComponentEvent::HIDE);

echo w4_render($divider);
```

### 4.7 Ejemplos equivalentes en Blade (`x-w4-divider`)

```blade
<x-w4-divider text="Visible" theme="daisyui" />
<x-w4-divider text="Activo" theme="daisyui" :active="true" />
<x-w4-divider text="Oculto" theme="daisyui" :hidden="true" />
```

## 5. 🧭 Ejemplos prácticos Daisy

Divider con `componentId` para auditoría/estado:

```blade
<x-w4-divider
    text="Separador auditado"
    theme="daisyui"
    :componentId="'divider-9001'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Divider\Divider::make()
        ->theme('daisyui')
        ->meta('component_id', 'divider-9001')
        ->attribute('data-component-id', 'divider-9001')
);
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
use W4\UiFramework\Components\UI\Divider\Divider;
use W4\UiFramework\Facades\W4Ui;

public function edit()
{
    $divider = Divider::make()
        ->name('profile_divider')
        ->id('div-profile')
        ->theme('daisyui')
        ->text('Perfil')
        ->variant('info')
        ->attribute('class', 'my-6');

    return view('profile.edit', [
        'dividerHtml' => W4Ui::render($divider),
    ]);
}
```

## 7. 📦 Notas de integración

- El Divider usa payload estándar (`renderer`, `view`, `data`, `theme`).
- `class` se mergea con las clases del resolver para conservar estilos base.
- Con `W4_UI_LOG=true`, registra en `storage/logs/w4.ui.log` si tiene `componentId`.
