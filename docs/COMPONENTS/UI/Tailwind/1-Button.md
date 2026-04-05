# 🚀 W4-UI-Framework

## ✨ Contexto del componente Tailwind Button

## 1. 📌 Información General

`Tailwind Button` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\UI\Button\Button`

y aplica estilos/atributos a través del resolver Tailwind:

`W4\UiFramework\Themes\Tailwind\Components\UI\ButtonThemeResolver`

Esto significa que toda la API funcional del botón base se conserva, y el tema Tailwind define cómo se ven variantes, tamaños y estados.

## 2. 🧱 API base del Button (heredada)

Creación base:

```php
use W4\UiFramework\Components\UI\Button\Button;

$button = Button::make('Guardar');
```

Fluent API más usada:

```php
$button = Button::make('Guardar')
    ->name('save')
    ->id('btn-save')
    ->theme('tailwind')
    ->variant('primary')
    ->size('md')
    ->attribute('type', 'submit');
```

Estados funcionales soportados:

- `enabled`
- `disabled`
- `loading`
- `active`
- `readonly`

Eventos soportados por la state machine del botón:

- `click`
- `disable`
- `enable`
- `start_loading`
- `finish_loading`
- `set_readonly`
- `set_active`
- `reset`

## 3. 🎨 Resolución visual Tailwind (ThemeResolver)

Según `ButtonThemeResolver`, Tailwind Button usa clases base:

- `inline-flex items-center justify-center`
- `rounded-md font-medium transition-colors`
- `focus:outline-none focus:ring-2 focus:ring-offset-2`
- `disabled:opacity-50 disabled:pointer-events-none`

### 3.1 Variantes Tailwind disponibles

Mapeo actual de `variant`:

- `neutral` -> `bg-slate-700 text-white hover:bg-slate-800 focus:ring-slate-500`
- `primary` -> `bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500`
- `secondary` -> `bg-slate-100 text-slate-900 hover:bg-slate-200 focus:ring-slate-400`
- `accent` -> `bg-violet-600 text-white hover:bg-violet-700 focus:ring-violet-500`
- `info` -> `bg-cyan-600 text-white hover:bg-cyan-700 focus:ring-cyan-500`
- `success` -> `bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500`
- `warning` -> `bg-amber-500 text-slate-900 hover:bg-amber-600 focus:ring-amber-500`
- `error` -> `bg-rose-600 text-white hover:bg-rose-700 focus:ring-rose-500`
- valor no reconocido -> usa fallback `primary`

### 3.2 Tamaños Tailwind disponibles

Mapeo actual de `size`:

- `xs` -> `px-2 py-1 text-xs`
- `sm` -> `px-3 py-1.5 text-sm`
- `md` -> `px-4 py-2 text-sm`
- `lg` -> `px-5 py-2.5 text-base`
- `xl` -> `px-6 py-3 text-lg`

### 3.3 Estados y clases adicionales

- `state=loading` agrega `opacity-75 cursor-wait`
- `state=active` agrega `ring-2 ring-offset-2`
- si el usuario pasa `class` en atributos, se hace merge con las clases resueltas
- si `class` incluye `h-*`, `min-h-*` o `max-h-*`, se remueven clases de tamaño para priorizar altura custom

Ejemplo de `class` con prioridad de alto:

```blade
<x-w4-button
    label="Guardar"
    theme="tailwind"
    variant="primary"
    size="sm"
    class="w-52 h-14"
/>
```

### 3.4 Atributos HTML resueltos

- `type`: usa el del usuario o `button` por defecto
- `disabled`: `true` cuando el estado es `disabled`, `loading` o `readonly`
- `aria-disabled`: `'true'` cuando el estado es `disabled`, `loading` o `readonly`
- `aria-pressed`: `'true'` cuando el estado es `active`

## 4. 🖥️ Formas de renderizar Tailwind Button

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Guardar')
        ->theme('tailwind')
        ->variant('primary')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Button\Button;

echo W4Ui::render(
    Button::make('Eliminar')
        ->theme('tailwind')
        ->variant('error')
        ->size('sm')
);
```

### 4.3 Componente Blade directo (`x-w4-button`)

```blade
<x-w4-button
    label="Guardar"
    theme="tailwind"
    variant="primary"
    size="md"
    type="submit"
/>
```

Parámetros Blade comunes:

- `label`
- `id`
- `name`
- `theme`
- `renderer`
- `variant`
- `size`
- `type`
- `icon`
- `disabled`
- `loading`
- `readonly`
- `active`
- `class`

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Guardar')
        ->theme('tailwind')
        ->variant('primary')
        ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('No disponible')
        ->theme('tailwind')
        ->variant('neutral')
        ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::DISABLED)
);
```

Render helper con estado `loading`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Procesando...')
        ->theme('tailwind')
        ->variant('info')
        ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::LOADING)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Seleccionado')
        ->theme('tailwind')
        ->variant('accent')
        ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::ACTIVE)
);
```

Render helper con estado `readonly`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Solo lectura')
        ->theme('tailwind')
        ->variant('warning')
        ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::READONLY)
);
```

Render por evento `set_active`:

```php
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Activar')
        ->theme('tailwind')
        ->variant('success')
        ->dispatch(ButtonComponentEvent::SET_ACTIVE)
);
```

Render por evento `start_loading`:

```php
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Cargando')
        ->theme('tailwind')
        ->variant('info')
        ->dispatch(ButtonComponentEvent::START_LOADING)
);
```

Render por evento `reset` después de activar:

```php
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;

$button = \W4\UiFramework\Components\UI\Button\Button::make('Reset')
    ->theme('tailwind')
    ->dispatch(ButtonComponentEvent::SET_ACTIVE)
    ->dispatch(ButtonComponentEvent::RESET);

echo w4_render($button);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-button`)

Render Blade equivalente a `enabled`:

```blade
<x-w4-button
    label="Guardar"
    theme="tailwind"
    variant="primary"
/>
```

Render Blade equivalente a `disabled`:

```blade
<x-w4-button
    label="No disponible"
    theme="tailwind"
    variant="neutral"
    :disabled="true"
/>
```

Render Blade equivalente a `loading`:

```blade
<x-w4-button
    label="Procesando..."
    theme="tailwind"
    variant="info"
    :loading="true"
/>
```

Render Blade equivalente a `active`:

```blade
<x-w4-button
    label="Seleccionado"
    theme="tailwind"
    variant="accent"
    :active="true"
/>
```

Render Blade equivalente a `readonly`:

```blade
<x-w4-button
    label="Solo lectura"
    theme="tailwind"
    variant="warning"
    :readonly="true"
/>
```

Render Blade simulando transición de eventos (`set_active` y `start_loading`) por props:

```blade
<x-w4-button
    label="Activado por estado"
    theme="tailwind"
    variant="success"
    :active="true"
/>

<x-w4-button
    label="Cargando por estado"
    theme="tailwind"
    variant="info"
    :loading="true"
/>
```

Para volver a estado base (`reset`) en Blade, renderiza el botón sin `:active`, `:loading`, `:disabled` ni `:readonly`.

Ejemplo de transición por evento:

```php
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;

$button = Button::make('Guardar')
    ->theme('tailwind')
    ->dispatch(ButtonComponentEvent::SET_ACTIVE);
```

## 5. 🧭 Ejemplos prácticos Tailwind

Botón submit principal:

```blade
<x-w4-button
    label="Guardar cambios"
    name="save"
    theme="tailwind"
    variant="primary"
    size="md"
    type="submit"
/>
```

Botón en loading:

```blade
<x-w4-button
    label="Procesando..."
    theme="tailwind"
    variant="info"
    :loading="true"
/>
```

Botón activo:

```blade
<x-w4-button
    label="Seleccionado"
    theme="tailwind"
    variant="accent"
    :active="true"
/>
```

Botón con ancho y alto custom:

```blade
<x-w4-button
    label="Guardar"
    theme="tailwind"
    variant="primary"
    size="sm"
    class="w-52 h-14"
/>
```

Botón con `componentId` para auditoría/estado:

```blade
<x-w4-button
    label="Guardar cambios"
    name="save"
    theme="tailwind"
    :componentId="12547"
    variant="primary"
    size="md"
    type="submit"
/>
```

Inspección backend de `componentId` en payload:

```php
use W4\UiFramework\Components\UI\Button\Button;

$button = Button::make('Guardar cambios')
    ->theme('tailwind')
    ->meta('component_id', 12547)
    ->attribute('data-component-id', '12547');

$debug = w4_debug_payload($button);

dd(
    $debug['component_id'],
    $debug['dom_component_id'],
    $debug['state'],
    $debug['payload']
);
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Facades\W4Ui;

class CheckoutController extends Controller
{
    public function create(): View
    {
        $submitButton = Button::make('Finalizar compra')
            ->name('checkout_submit')
            ->id('btn-checkout-submit')
            ->theme('tailwind')
            ->variant('success')
            ->size('lg')
            ->attribute('type', 'submit');

        return view('checkout.create', [
            'submitButtonHtml' => W4Ui::render($submitButton),
        ]);
    }
}
```

En la vista:

```blade
<form method="POST" action="{{ route('checkout.store') }}">
    @csrf
    {!! $submitButtonHtml !!}
</form>
```

## 7. 📦 Notas de integración

- El Tailwind Button usa el mismo payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `tailwind` (global o por componente).
- Si usas Tailwind con purga de clases, asegúrate de incluir utilidades dinámicas usadas en `class` dentro del escaneo/safelist de tu app consumidora.
