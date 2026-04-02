# 🚀 W4-UI-Framework

## ✨ Contexto del componente Daisy Button

## 1. 📌 Información General

`Daisy Button` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\UI\Button\Button`

y aplica estilos/atributos a través del resolver DaisyUI:

`W4\UiFramework\Themes\DaisyUI\Components\UI\ButtonThemeResolver`

Esto significa que toda la API funcional del botón base se conserva, y el tema DaisyUI define cómo se ven las variantes, tamaños y estados.

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
    ->theme('daisyui')
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

## 3. 🎨 Resolución visual DaisyUI (ThemeResolver)

Según `ButtonThemeResolver`, Daisy Button usa clase base:

- `btn`

### 3.1 Variantes Daisy disponibles

Mapeo actual de `variant`:

- `neutral` -> `btn-neutral`
- `primary` -> `btn-primary`
- `secondary` -> `btn-secondary`
- `accent` -> `btn-accent`
- `info` -> `btn-info`
- `success` -> `btn-success`
- `warning` -> `btn-warning`
- `error` -> `btn-error`
- valor no reconocido -> `btn-neutral`

### 3.2 Tamaños Daisy disponibles

Mapeo actual de `size`:

- `xs` -> `btn-xs`
- `sm` -> `btn-sm`
- `md` -> `btn` (sin extra adicional)
- `lg` -> `btn-lg`
- `xl` -> `btn-xl`

### 3.3 Estados y clases adicionales

- `state=loading` agrega `loading`
- `state=active` agrega `btn-active`
- si el usuario pasa `class` en atributos, se hace merge con las clases resueltas

### 3.4 Atributos HTML resueltos

El resolver también fija atributos:

- `type`: usa el del usuario o `button` por defecto
- `disabled`: `true` cuando el estado es `disabled`, `loading` o `readonly`
- `aria-disabled`: `'true'` cuando el estado es `disabled`, `loading` o `readonly`
- `aria-pressed`: `'true'` cuando el estado es `active`

## 4. 🖥️ Formas de renderizar Daisy Button

Nota de uso de tema:

- Usa `theme="daisyui"` en `x-w4-button` cuando el tema global de tu proyecto no sea DaisyUI y quieras forzar Daisy solo para ese botón.
- Usa `->theme('daisyui')` en `Button::make(...)` cuando renderizas por helper/facade/controlador y quieres forzar Daisy en esa instancia.
- Si tu configuración global ya está en DaisyUI (`W4_UI_THEME=daisyui`), no es obligatorio repetir `theme="daisyui"` ni `->theme('daisyui')`.
- Mantén `theme="daisyui"` o `->theme('daisyui')` en ejemplos de documentación cuando quieras que el snippet sea explícito y no dependa de la configuración global.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Guardar')
        ->theme('daisyui')
        ->variant('primary')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Button\Button;

echo W4Ui::render(
    Button::make('Eliminar')
        ->theme('daisyui')
        ->variant('error')
        ->size('sm')
);
```

### 4.3 Componente Blade directo (`x-w4-button`)

```blade
<x-w4-button
    label="Guardar"
    theme="daisyui"
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

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Guardar')
        ->theme('daisyui')
        ->variant('primary')
        ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('No disponible')
        ->theme('daisyui')
        ->variant('neutral')
        ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::DISABLED)
);
```

Render helper con estado `loading`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Procesando...')
        ->theme('daisyui')
        ->variant('info')
        ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::LOADING)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Seleccionado')
        ->theme('daisyui')
        ->variant('accent')
        ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::ACTIVE)
);
```

Render helper con estado `readonly`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Solo lectura')
        ->theme('daisyui')
        ->variant('warning')
        ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::READONLY)
);
```

Render por evento `set_active`:

```php
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Activar')
        ->theme('daisyui')
        ->variant('success')
        ->dispatch(ButtonComponentEvent::SET_ACTIVE)
);
```

Render por evento `start_loading`:

```php
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\Button\Button::make('Cargando')
        ->theme('daisyui')
        ->variant('info')
        ->dispatch(ButtonComponentEvent::START_LOADING)
);
```

Render por evento `reset` después de activar:

```php
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;

$button = \W4\UiFramework\Components\UI\Button\Button::make('Reset')
    ->theme('daisyui')
    ->dispatch(ButtonComponentEvent::SET_ACTIVE)
    ->dispatch(ButtonComponentEvent::RESET);

echo w4_render($button);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-button`)

Render Blade equivalente a `enabled`:

```blade
<x-w4-button
    label="Guardar"
    theme="daisyui"
    variant="primary"
/>
```

Render Blade equivalente a `disabled`:

```blade
<x-w4-button
    label="No disponible"
    theme="daisyui"
    variant="neutral"
    :disabled="true"
/>
```

Render Blade equivalente a `loading`:

```blade
<x-w4-button
    label="Procesando..."
    theme="daisyui"
    variant="info"
    :loading="true"
/>
```

Render Blade equivalente a `active`:

```blade
<x-w4-button
    label="Seleccionado"
    theme="daisyui"
    variant="accent"
    :active="true"
/>
```

Render Blade equivalente a `readonly`:

```blade
<x-w4-button
    label="Solo lectura"
    theme="daisyui"
    variant="warning"
    :readonly="true"
/>
```

Render Blade simulando transición de eventos (`set_active` y `start_loading`) por props:

```blade
<x-w4-button
    label="Activado por estado"
    theme="daisyui"
    variant="success"
    :active="true"
/>

<x-w4-button
    label="Cargando por estado"
    theme="daisyui"
    variant="info"
    :loading="true"
/>
```

Para volver a estado base (`reset`) en Blade, renderiza el botón sin `:active`, `:loading`, `:disabled` ni `:readonly`.

Ejemplo de transición por evento:

```php
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;

$button = Button::make('Guardar')
    ->theme('daisyui')
    ->dispatch(ButtonComponentEvent::SET_ACTIVE);
```

## 5. 🧭 Ejemplos prácticos Daisy

Botón submit principal:

```blade
<x-w4-button
    label="Guardar cambios"
    name="save"
    theme="daisyui"
    variant="primary"
    size="md"
    type="submit"
/>
```

Botón en loading:

```blade
<x-w4-button
    label="Procesando..."
    theme="daisyui"
    variant="info"
    :loading="true"
/>
```

Botón activo:

```blade
<x-w4-button
    label="Seleccionado"
    theme="daisyui"
    variant="accent"
    :active="true"
/>
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
            ->theme('daisyui')
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

- El Daisy Button usa el mismo payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `daisyui` (global o por componente).
- Si usas Tailwind/DaisyUI con purga de clases, asegúrate de incluir las clases `btn-*`, `loading` y `btn-active` en el escaneo/safelist de tu app consumidora.
