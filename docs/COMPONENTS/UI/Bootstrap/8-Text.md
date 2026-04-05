# 🚀 W4-UI-Framework

## ✨ Contexto del componente Bootstrap Text

## 1. 📌 Información General

`Bootstrap Text` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\UI\Text\Text`

y aplica estilos/atributos a través del resolver Bootstrap:

`W4\UiFramework\Themes\Bootstrap\Components\UI\TextThemeResolver`

Esto significa que la API funcional del texto base se conserva, y Bootstrap define cómo se ven variantes, tamaños y estados.

## 2. 🧱 API base del Text (heredada)

Creación base:

```php
use W4\UiFramework\Components\UI\Text\Text;

$text = Text::make('Estado');
```

Fluent API más usada:

```php
$text = Text::make('Estado')
    ->name('status_text')
    ->id('txt-status')
    ->theme('bootstrap')
    ->text('Estado del sistema')
    ->variant('primary')
    ->size('md');
```

Estados funcionales soportados:

- `enabled`
- `disabled`
- `active`
- `hidden`

Eventos soportados por la state machine del texto:

- `activate`
- `deactivate`
- `disable`
- `enable`
- `hide`
- `show`
- `reset`

## 3. 🎨 Resolución visual Bootstrap (ThemeResolver)

Según `TextThemeResolver`, Bootstrap Text usa clase base:

- `d-inline-block`

### 3.1 Variantes Bootstrap disponibles

Mapeo actual de `variant`:

- `primary` -> `text-primary`
- `secondary` -> `text-secondary`
- `success` -> `text-success`
- `warning` -> `text-warning`
- `danger` o `error` -> `text-danger`
- `info` -> `text-info`
- `light` -> `text-light`
- `dark` -> `text-dark`
- `neutral` y valor no reconocido -> `text-body`

### 3.2 Tamaños Bootstrap disponibles

Mapeo actual de `size`:

- `xs` -> `fs-6`
- `sm` -> `fs-5`
- `md` -> `fs-4`
- `lg` -> `fs-3`
- `xl` -> `fs-2`

### 3.3 Estados y clases adicionales

- `state=disabled` agrega `opacity-50`
- `state=active` agrega `fw-semibold`
- `state=hidden` agrega `d-none`
- si el usuario pasa `class` en atributos, se hace merge con las clases resueltas

### 3.4 Atributos HTML resueltos

El resolver/flujo final de render también contempla atributos:

- `role`: por defecto `text`
- `aria-hidden`: `'true'` cuando el estado es `hidden`
- `data-state`: estado final del componente

## 4. 🖥️ Formas de renderizar Bootstrap Text

Nota de uso de tema:

- Usa `theme="bootstrap"` en `x-w4-text` cuando el tema global de tu app no sea Bootstrap y quieras forzar Bootstrap solo para ese texto.
- Usa `->theme('bootstrap')` en `Text::make(...)` cuando renderizas por helper/facade/controlador y quieras forzar Bootstrap en esa instancia.
- Si tu configuración global ya está en Bootstrap, no es obligatorio repetir `theme="bootstrap"` ni `->theme('bootstrap')`.
- Mantén `theme="bootstrap"` o `->theme('bootstrap')` en snippets de documentación cuando quieras un ejemplo explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Estado')
        ->theme('bootstrap')
        ->text('Estado activo')
        ->variant('success')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Text\Text;

echo W4Ui::render(
    Text::make('Resumen')
        ->theme('bootstrap')
        ->text('Operación completada')
        ->variant('primary')
        ->size('lg')
);
```

### 4.3 Componente Blade directo (`x-w4-text`)

```blade
<x-w4-text
    theme="bootstrap"
    label="Estado"
    text="Operación completada"
    variant="primary"
    size="md"
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
- `disabled`
- `active`
- `hidden`
- `class`

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Visible')
        ->theme('bootstrap')
        ->text('Texto visible')
        ->state(\W4\UiFramework\Components\UI\Text\TextComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Deshabilitado')
        ->theme('bootstrap')
        ->text('Texto bloqueado')
        ->state(\W4\UiFramework\Components\UI\Text\TextComponentState::DISABLED)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Activo')
        ->theme('bootstrap')
        ->text('Texto activo')
        ->state(\W4\UiFramework\Components\UI\Text\TextComponentState::ACTIVE)
);
```

Render por evento `activate`:

```php
use W4\UiFramework\Components\UI\Text\TextComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Activar texto')
        ->theme('bootstrap')
        ->text('Pendiente')
        ->dispatch(TextComponentEvent::ACTIVATE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\UI\Text\TextComponentEvent;

$text = \W4\UiFramework\Components\UI\Text\Text::make('Reset')
    ->theme('bootstrap')
    ->text('Texto temporal')
    ->dispatch(TextComponentEvent::ACTIVATE)
    ->dispatch(TextComponentEvent::RESET);

echo w4_render($text);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-text`)

```blade
<x-w4-text label="Activo" theme="bootstrap" :active="true" />
<x-w4-text label="Deshabilitado" theme="bootstrap" :disabled="true" />
<x-w4-text label="Oculto" theme="bootstrap" :hidden="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el texto sin `:active`, `:disabled` ni `:hidden`.

## 5. 🧭 Ejemplos prácticos Bootstrap

Texto de estado:

```blade
<x-w4-text
    label="Estado"
    theme="bootstrap"
    text="Operación completada"
    variant="success"
    size="md"
/>
```

Texto destacado:

```blade
<x-w4-text
    label="Aviso"
    theme="bootstrap"
    text="Requiere revisión"
    variant="warning"
    :active="true"
/>
```

Texto con `componentId` para auditoría/estado:

```blade
<x-w4-text
    label="Texto auditado"
    theme="bootstrap"
    :componentId="'text-9001'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Text\Text::make('Audit')
        ->theme('bootstrap')
        ->meta('component_id', 'text-9001')
        ->attribute('data-component-id', 'text-9001')
);
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\UI\Text\Text;
use W4\UiFramework\Facades\W4Ui;

class StatusController extends Controller
{
    public function index(): View
    {
        $statusText = Text::make('Estado')
            ->name('status_text')
            ->id('txt-status')
            ->theme('bootstrap')
            ->text('Operación completada')
            ->variant('success')
            ->size('md');

        return view('status.index', [
            'statusTextHtml' => W4Ui::render($statusText),
        ]);
    }
}
```

En la vista:

```blade
{!! $statusTextHtml !!}
```

## 7. 📦 Notas de integración

- El Bootstrap Text usa payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `bootstrap` (global o por componente).
- Si usas optimización de CSS en producción, asegúrate de incluir clases `text-*`, `fs-*`, `d-none`, `opacity-50` y `fw-semibold`.
