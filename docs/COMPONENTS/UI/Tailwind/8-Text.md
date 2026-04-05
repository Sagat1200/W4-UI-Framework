# 🚀 W4-UI-Framework

## ✨ Contexto del componente Tailwind Text

## 1. 📌 Información General

`Tailwind Text` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\UI\Text\Text`

y aplica estilos/atributos a través del resolver Tailwind:

`W4\UiFramework\Themes\Tailwind\Components\UI\TextThemeResolver`

Esto significa que la API funcional del texto base se conserva, y el tema Tailwind define cómo se ven variantes, tamaños y estados.

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
    ->theme('tailwind')
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

## 3. 🎨 Resolución visual Tailwind (ThemeResolver)

Según `TextThemeResolver`, Tailwind Text usa clases base:

- `inline-block`
- `leading-snug`

### 3.1 Variantes Tailwind disponibles

Mapeo actual de `variant`:

- `neutral` -> `text-slate-900`
- `primary` -> `text-blue-600`
- `secondary` -> `text-slate-700`
- `accent` -> `text-violet-600`
- `success` -> `text-emerald-600`
- `warning` -> `text-amber-600`
- `error` -> `text-rose-600`
- `info` -> `text-cyan-600`
- valor no reconocido -> `text-slate-900`

### 3.2 Tamaños Tailwind disponibles

Mapeo actual de `size`:

- `xs` -> `text-xs`
- `sm` -> `text-sm`
- `md` -> `text-base`
- `lg` -> `text-lg`
- `xl` -> `text-xl`

### 3.3 Estados y clases adicionales

- `state=disabled` agrega `opacity-50`
- `state=active` agrega `font-semibold`
- `state=hidden` agrega `hidden`
- si el usuario pasa `class` en atributos, se hace merge con las clases resueltas

### 3.4 Atributos HTML resueltos

El resolver/flujo final de render también contempla atributos:

- `role`: por defecto `text`
- `aria-hidden`: `'true'` cuando el estado es `hidden`
- `data-state`: estado final del componente

## 4. 🖥️ Formas de renderizar Tailwind Text

Nota de uso de tema:

- Usa `theme="tailwind"` en `x-w4-text` cuando el tema global de tu app no sea Tailwind y quieras forzar Tailwind solo para ese texto.
- Usa `->theme('tailwind')` en `Text::make(...)` cuando renderizas por helper/facade/controlador y quieras forzar Tailwind en esa instancia.
- Si tu configuración global ya está en Tailwind, no es obligatorio repetir `theme="tailwind"` ni `->theme('tailwind')`.
- Mantén `theme="tailwind"` o `->theme('tailwind')` en snippets de documentación cuando quieras un ejemplo explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Estado')
        ->theme('tailwind')
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
        ->theme('tailwind')
        ->text('Operación completada')
        ->variant('primary')
        ->size('lg')
);
```

### 4.3 Componente Blade directo (`x-w4-text`)

```blade
<x-w4-text
    theme="tailwind"
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
        ->theme('tailwind')
        ->text('Texto visible')
        ->state(\W4\UiFramework\Components\UI\Text\TextComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Deshabilitado')
        ->theme('tailwind')
        ->text('Texto bloqueado')
        ->state(\W4\UiFramework\Components\UI\Text\TextComponentState::DISABLED)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Activo')
        ->theme('tailwind')
        ->text('Texto activo')
        ->state(\W4\UiFramework\Components\UI\Text\TextComponentState::ACTIVE)
);
```

Render por evento `activate`:

```php
use W4\UiFramework\Components\UI\Text\TextComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Activar texto')
        ->theme('tailwind')
        ->text('Pendiente')
        ->dispatch(TextComponentEvent::ACTIVATE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\UI\Text\TextComponentEvent;

$text = \W4\UiFramework\Components\UI\Text\Text::make('Reset')
    ->theme('tailwind')
    ->text('Texto temporal')
    ->dispatch(TextComponentEvent::ACTIVATE)
    ->dispatch(TextComponentEvent::RESET);

echo w4_render($text);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-text`)

```blade
<x-w4-text label="Activo" theme="tailwind" :active="true" />
<x-w4-text label="Deshabilitado" theme="tailwind" :disabled="true" />
<x-w4-text label="Oculto" theme="tailwind" :hidden="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el texto sin `:active`, `:disabled` ni `:hidden`.

## 5. 🧭 Ejemplos prácticos Tailwind

Texto de estado:

```blade
<x-w4-text
    label="Estado"
    theme="tailwind"
    text="Operación completada"
    variant="success"
    size="md"
/>
```

Texto destacado:

```blade
<x-w4-text
    label="Aviso"
    theme="tailwind"
    text="Requiere revisión"
    variant="warning"
    :active="true"
/>
```

Texto con `componentId` para auditoría/estado:

```blade
<x-w4-text
    label="Texto auditado"
    theme="tailwind"
    :componentId="'text-9003'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Text\Text::make('Audit')
        ->theme('tailwind')
        ->meta('component_id', 'text-9003')
        ->attribute('data-component-id', 'text-9003')
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
            ->theme('tailwind')
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

- El Tailwind Text usa payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `tailwind` (global o por componente).
- Si usas purge en Tailwind, asegúrate de incluir clases `text-*`, `hidden`, `opacity-50` y `font-semibold`.
