# 🚀 W4-UI-Framework

## ✨ Contexto del componente Daisy Input

## 1. 📌 Información General

`Daisy Input` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\Forms\Input\Input`

y aplica estilos/atributos a través del resolver DaisyUI:

`W4\UiFramework\Themes\DaisyUI\Components\Forms\InputThemeResolver`

Esto significa que toda la API funcional del input base se conserva, y el tema DaisyUI define cómo se ven las variantes, tamaños, estados e interacción visual.

## 2. 🧱 API base del Input (heredada)

Creación base:

```php
use W4\UiFramework\Components\Forms\Input\Input;

$input = Input::make('Correo');
```

Fluent API más usada:

```php
use W4\UiFramework\Components\Forms\Input\InputComponentEvent;

$input = Input::make('Correo')
    ->name('email')
    ->id('input-email')
    ->theme('daisyui')
    ->type('email')
    ->placeholder('correo@dominio.com')
    ->variant('primary')
    ->size('md')
    ->dispatch(InputComponentEvent::SET_VALID);
```

Estados funcionales soportados:

- `enabled`
- `disabled`
- `readonly`
- `invalid`
- `valid`
- `loading`

Eventos soportados por la state machine del input:

- `focus`
- `blur`
- `input`
- `disable`
- `enable`
- `set_readonly`
- `set_invalid`
- `set_valid`
- `start_loading`
- `finish_loading`
- `reset`

Métodos de conveniencia disponibles:

- `disable()`
- `enable()`
- `setReadonly()`
- `setInvalid()`
- `setValid()`
- `startLoading()`
- `finishLoading()`
- `resetState()`
- `can(InputComponentEvent $event)`
- `dispatch(InputComponentEvent $event)`

Ejemplo de transición por evento:

```php
use W4\UiFramework\Components\Forms\Input\InputComponentEvent;

$input = Input::make('Correo')
    ->theme('daisyui')
    ->dispatch(InputComponentEvent::SET_INVALID);
```

## 3. 🎨 Resolución visual DaisyUI (ThemeResolver)

Según `InputThemeResolver`, Daisy Input usa clases base:

- `input`
- `input-bordered`
- `w-full`

### 3.1 Variantes Daisy disponibles

Mapeo actual de `variant`:

- `neutral` -> `input-neutral`
- `primary` -> `input-primary`
- `secondary` -> `input-secondary`
- `accent` -> `input-accent`
- `success` -> `input-success`
- `warning` -> `input-warning`
- `error` -> `input-error`
- valor no reconocido -> `input-neutral`

### 3.2 Tamaños Daisy disponibles

Mapeo actual de `size`:

- `xs` -> `input-xs`
- `sm` -> `input-sm`
- `md` -> `input-md`
- `lg` -> `input-lg`
- `xl` -> `input-xl`

### 3.3 Estados y clases adicionales

- `state=valid` agrega `input-success`
- `state=invalid` agrega `input-error`
- `state=loading` agrega `opacity-75`
- `interact_state.focused=true` agrega `ring`
- si el usuario pasa `class` en atributos, se hace merge con las clases resueltas

### 3.4 Atributos HTML resueltos

El resolver también fija atributos:

- `type`: usa valor de contexto, o valor del usuario, o `text` por defecto
- `name`, `id`, `value`, `placeholder`: respetan prioridad de contexto/atributos
- `disabled`: `true` cuando el estado es `disabled` o `loading`
- `readonly`: `true` cuando el estado es `readonly`
- `aria-invalid`: `'true'` cuando el estado es `invalid`
- `aria-busy`: `'true'` cuando el estado es `loading`
- `data-focused`, `data-hovered`, `data-filled`: derivados de `interact_state`

## 4. 🖥️ Formas de renderizar Daisy Input

Nota de uso de tema:

- Usa `theme="daisyui"` en `x-w4-input` cuando el tema global de tu proyecto no sea DaisyUI y quieras forzar Daisy solo para ese input.
- Usa `->theme('daisyui')` en `Input::make(...)` cuando renderizas por helper/facade/controlador y quieres forzar Daisy en esa instancia.
- Si tu configuración global ya está en DaisyUI (`W4_UI_THEME=daisyui`), no es obligatorio repetir `theme="daisyui"` ni `->theme('daisyui')`.
- Mantén `theme="daisyui"` o `->theme('daisyui')` en ejemplos de documentación cuando quieras que el snippet sea explícito y no dependa de la configuración global.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Input\Input::make('Usuario')
        ->theme('daisyui')
        ->name('username')
        ->placeholder('tu usuario')
        ->variant('primary')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\Forms\Input\Input;

echo W4Ui::render(
    Input::make('Correo')
        ->theme('daisyui')
        ->type('email')
        ->variant('error')
        ->size('sm')
);
```

### 4.3 Componente Blade directo (`x-w4-input`)

```blade
<x-w4-input
    label="Correo"
    theme="daisyui"
    name="email"
    type="email"
    variant="primary"
    size="md"
    placeholder="correo@dominio.com"
/>
```

Parámetros Blade comunes:

- `label`
- `id`
- `name`
- `theme`
- `renderer`
- `type`
- `value`
- `placeholder`
- `helperText`
- `errorMessage`
- `variant`
- `size`
- `disabled`
- `loading`
- `readonly`
- `invalid`
- `valid`
- `focused`
- `hovered`
- `filled`

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Input\Input::make('Correo')
        ->theme('daisyui')
        ->variant('neutral')
        ->state(\W4\UiFramework\Components\Forms\Input\InputComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Input\Input::make('No editable')
        ->theme('daisyui')
        ->variant('neutral')
        ->state(\W4\UiFramework\Components\Forms\Input\InputComponentState::DISABLED)
);
```

Render helper con estado `loading`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Input\Input::make('Buscando')
        ->theme('daisyui')
        ->variant('primary')
        ->state(\W4\UiFramework\Components\Forms\Input\InputComponentState::LOADING)
);
```

Render helper con estado `invalid`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Input\Input::make('Correo')
        ->theme('daisyui')
        ->variant('error')
        ->errorMessage('Correo inválido')
        ->state(\W4\UiFramework\Components\Forms\Input\InputComponentState::INVALID)
);
```

Render helper con estado `valid`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Input\Input::make('Correo')
        ->theme('daisyui')
        ->variant('success')
        ->state(\W4\UiFramework\Components\Forms\Input\InputComponentState::VALID)
);
```

Render por evento `set_invalid`:

```php
use W4\UiFramework\Components\Forms\Input\InputComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\Input\Input::make('Validación')
        ->theme('daisyui')
        ->variant('error')
        ->dispatch(InputComponentEvent::SET_INVALID)
);
```

Render por evento `start_loading`:

```php
use W4\UiFramework\Components\Forms\Input\InputComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\Input\Input::make('Consultar')
        ->theme('daisyui')
        ->variant('primary')
        ->dispatch(InputComponentEvent::START_LOADING)
);
```

Render por evento `reset` después de invalidar:

```php
use W4\UiFramework\Components\Forms\Input\InputComponentEvent;

$input = \W4\UiFramework\Components\Forms\Input\Input::make('Reset')
    ->theme('daisyui')
    ->dispatch(InputComponentEvent::SET_INVALID)
    ->dispatch(InputComponentEvent::RESET);

echo w4_render($input);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-input`)

Render Blade equivalente a `enabled`:

```blade
<x-w4-input
    label="Correo"
    theme="daisyui"
    variant="neutral"
/>
```

Render Blade equivalente a `disabled`:

```blade
<x-w4-input
    label="No editable"
    theme="daisyui"
    variant="neutral"
    :disabled="true"
/>
```

Render Blade equivalente a `loading`:

```blade
<x-w4-input
    label="Buscando"
    theme="daisyui"
    variant="primary"
    :loading="true"
/>
```

Render Blade equivalente a `invalid`:

```blade
<x-w4-input
    label="Correo"
    theme="daisyui"
    variant="error"
    errorMessage="Correo inválido"
    :invalid="true"
/>
```

Render Blade equivalente a `valid`:

```blade
<x-w4-input
    label="Correo válido"
    theme="daisyui"
    variant="success"
    :valid="true"
/>
```

Render Blade simulando transición de eventos (`set_invalid` y `start_loading`) por props:

```blade
<x-w4-input
    label="Inválido por estado"
    theme="daisyui"
    variant="error"
    :invalid="true"
/>

<x-w4-input
    label="Cargando por estado"
    theme="daisyui"
    variant="primary"
    :loading="true"
/>
```

Para volver a estado base (`reset`) en Blade, renderiza el input sin `:invalid`, `:valid`, `:loading`, `:disabled` ni `:readonly`.

Ejemplo de transición por evento:

```php
use W4\UiFramework\Components\Forms\Input\InputComponentEvent;

$input = Input::make('Correo')
    ->theme('daisyui')
    ->dispatch(InputComponentEvent::SET_INVALID);
```

## 5. 🧭 Ejemplos prácticos Daisy

Input de correo con validación:

```blade
<x-w4-input
    label="Correo"
    name="email"
    theme="daisyui"
    type="email"
    variant="primary"
    placeholder="correo@dominio.com"
/>
```

Input con estado inválido:

```blade
<x-w4-input
    label="Correo"
    name="email"
    theme="daisyui"
    variant="error"
    errorMessage="Correo inválido"
    :invalid="true"
/>
```

Input con interacción marcada:

```blade
<x-w4-input
    label="Usuario"
    name="username"
    theme="daisyui"
    :focused="true"
    :hovered="true"
    :filled="true"
    value="john.doe"
/>
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\Forms\Input\Input;
use W4\UiFramework\Components\Forms\Input\InputComponentEvent;
use W4\UiFramework\Facades\W4Ui;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $emailInput = Input::make('Correo')
            ->name('email')
            ->id('input-email')
            ->theme('daisyui')
            ->type('email')
            ->variant('error')
            ->placeholder('correo@dominio.com')
            ->dispatch(InputComponentEvent::SET_INVALID)
            ->errorMessage('Formato de correo inválido');

        return view('profile.edit', [
            'emailInputHtml' => W4Ui::render($emailInput),
        ]);
    }
}
```

En la vista:

```blade
<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    {!! $emailInputHtml !!}
</form>
```

## 7. 📦 Notas de integración

- El Daisy Input usa el mismo payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `daisyui` (global o por componente).
- El wrapper `x-w4-input` mapea props de estado a eventos de `InputComponentEvent`.
- Si usas Tailwind/DaisyUI con purga de clases, asegúrate de incluir `input-*`, `opacity-75` y `ring` en el escaneo/safelist de tu app consumidora.
