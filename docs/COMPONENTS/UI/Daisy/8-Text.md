# 🚀 W4-UI-Framework

## ✨ Contexto del componente Daisy Text

## 1. 📌 Información General

`Daisy Text` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\UI\Text\Text`

y aplica estilos/atributos a través del resolver DaisyUI:

`W4\UiFramework\Themes\DaisyUI\Components\UI\TextThemeResolver`

Esto significa que la API funcional del texto base se conserva, y el tema DaisyUI define cómo se ven variantes, tamaños y estados.

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
    ->theme('daisyui')
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

## 3. 🎨 Resolución visual DaisyUI (ThemeResolver)

Según `TextThemeResolver`, Daisy Text usa clase base:

- `inline-block`

### 3.1 Variantes Daisy disponibles

Mapeo actual de `variant`:

- `neutral` -> `text-base-content`
- `primary` -> `text-primary`
- `secondary` -> `text-secondary`
- `accent` -> `text-accent`
- `success` -> `text-success`
- `warning` -> `text-warning`
- `error` -> `text-error`
- `info` -> `text-info`
- valor no reconocido -> `text-base-content`

### 3.2 Tamaños Daisy disponibles

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

## 4. 🖥️ Formas de renderizar Daisy Text

Nota de uso de tema:

- Usa `theme="daisyui"` en `x-w4-text` cuando el tema global de tu app no sea DaisyUI y quieras forzar Daisy solo para ese texto.
- Usa `->theme('daisyui')` en `Text::make(...)` cuando renderizas por helper/facade/controlador y quieras forzar Daisy en esa instancia.
- Si tu configuración global ya está en DaisyUI, no es obligatorio repetir `theme="daisyui"` ni `->theme('daisyui')`.
- Mantén `theme="daisyui"` o `->theme('daisyui')` en snippets de documentación cuando quieras un ejemplo explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Estado')
        ->theme('daisyui')
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
        ->theme('daisyui')
        ->text('Operación completada')
        ->variant('primary')
        ->size('lg')
);
```

### 4.3 Componente Blade directo (`x-w4-text`)

```blade
<x-w4-text
    theme="daisyui"
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
        ->theme('daisyui')
        ->text('Texto visible')
        ->state(\W4\UiFramework\Components\UI\Text\TextComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Deshabilitado')
        ->theme('daisyui')
        ->text('Texto bloqueado')
        ->state(\W4\UiFramework\Components\UI\Text\TextComponentState::DISABLED)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Activo')
        ->theme('daisyui')
        ->text('Texto activo')
        ->state(\W4\UiFramework\Components\UI\Text\TextComponentState::ACTIVE)
);
```

Render por evento `activate`:

```php
use W4\UiFramework\Components\UI\Text\TextComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Activar texto')
        ->theme('daisyui')
        ->text('Pendiente')
        ->dispatch(TextComponentEvent::ACTIVATE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\UI\Text\TextComponentEvent;

$text = \W4\UiFramework\Components\UI\Text\Text::make('Reset')
    ->theme('daisyui')
    ->text('Texto temporal')
    ->dispatch(TextComponentEvent::ACTIVATE)
    ->dispatch(TextComponentEvent::RESET);

echo w4_render($text);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-text`)

```blade
<x-w4-text label="Activo" theme="daisyui" :active="true" />
<x-w4-text label="Deshabilitado" theme="daisyui" :disabled="true" />
<x-w4-text label="Oculto" theme="daisyui" :hidden="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el texto sin `:active`, `:disabled` ni `:hidden`.

## 5. 🧭 Ejemplos prácticos Daisy

Texto de estado:

```blade
<x-w4-text
    label="Estado"
    theme="daisyui"
    text="Operación completada"
    variant="success"
    size="md"
/>
```

Texto destacado:

```blade
<x-w4-text
    label="Aviso"
    theme="daisyui"
    text="Requiere revisión"
    variant="warning"
    :active="true"
/>
```

Texto con `componentId` para auditoría/estado:

```blade
<x-w4-text
    label="Texto auditado"
    theme="daisyui"
    :componentId="'text-9002'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Text\Text::make('Audit')
        ->theme('daisyui')
        ->meta('component_id', 'text-9002')
        ->attribute('data-component-id', 'text-9002')
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
            ->theme('daisyui')
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

- El Daisy Text usa payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `daisyui` (global o por componente).
- Si usas purge en Tailwind/DaisyUI, asegúrate de incluir clases `text-*`, `hidden`, `opacity-50` y `font-semibold`.
