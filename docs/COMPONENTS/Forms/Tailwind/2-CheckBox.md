# 🚀 W4-UI-Framework

## ✨ Contexto del componente Tailwind CheckBox

## 1. 📌 Información General

`Tailwind CheckBox` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\Forms\CheckBox\CheckBox`

y aplica estilos/atributos a través del resolver Tailwind:

`W4\UiFramework\Themes\Tailwind\Components\Forms\CheckBoxThemeResolver`

Esto significa que toda la API funcional del checkbox base se conserva, y el tema Tailwind define cómo se ven variantes, tamaños, estados e interacción visual.

## 2. 🧱 API base del CheckBox (heredada)

Creación base:

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBox;

$checkbox = CheckBox::make('Acepto términos');
```

Fluent API más usada:

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentEvent;

$checkbox = CheckBox::make('Acepto términos')
    ->name('terms')
    ->id('checkbox-terms')
    ->theme('tailwind')
    ->value('1')
    ->checked(true)
    ->variant('primary')
    ->size('md')
    ->dispatch(CheckBoxComponentEvent::SET_VALID);
```

Estados funcionales soportados:

- `enabled`
- `disabled`
- `readonly`
- `invalid`
- `valid`
- `loading`

Eventos soportados por la state machine del checkbox:

- `focus`
- `blur`
- `change`
- `check`
- `uncheck`
- `toggle`
- `set_indeterminate`
- `clear_indeterminate`
- `disable`
- `enable`
- `set_readonly`
- `set_invalid`
- `set_valid`
- `start_loading`
- `finish_loading`
- `reset`

Métodos de conveniencia disponibles:

- `check()`
- `uncheck()`
- `toggle()`
- `setIndeterminate()`
- `clearIndeterminate()`
- `disable()`
- `enable()`
- `setReadonly()`
- `setInvalid()`
- `setValid()`
- `startLoading()`
- `finishLoading()`
- `resetState()`
- `can(CheckBoxComponentEvent $event)`
- `dispatch(CheckBoxComponentEvent $event)`

Ejemplo de transición por evento:

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentEvent;

$checkbox = CheckBox::make('Acepto términos')
    ->theme('tailwind')
    ->dispatch(CheckBoxComponentEvent::SET_INVALID);
```

## 3. 🎨 Resolución visual Tailwind (ThemeResolver)

Según `CheckBoxThemeResolver`, Tailwind CheckBox usa clases base:

- `rounded`
- `border`
- `transition`
- `focus:outline-none`
- `focus:ring-2`
- `disabled:opacity-50`
- `disabled:cursor-not-allowed`

### 3.1 Variantes Tailwind disponibles

Mapeo actual de `variant`:

- `neutral` y `default` -> `border-slate-300 text-slate-700 focus:ring-slate-400`
- `primary` -> `border-blue-400 text-blue-600 focus:ring-blue-500`
- `secondary` -> `border-slate-400 text-slate-600 focus:ring-slate-500`
- `accent` -> `border-violet-400 text-violet-600 focus:ring-violet-500`
- `success` -> `border-emerald-400 text-emerald-600 focus:ring-emerald-500`
- `warning` -> `border-amber-400 text-amber-600 focus:ring-amber-500`
- `error` o `danger` -> `border-rose-400 text-rose-600 focus:ring-rose-500`
- `info` -> `border-cyan-400 text-cyan-600 focus:ring-cyan-500`
- valor no reconocido -> `border-slate-300 text-slate-700 focus:ring-slate-400`

### 3.2 Tamaños Tailwind disponibles

Mapeo actual de `size`:

- `xs` -> `h-3 w-3`
- `sm` -> `h-4 w-4`
- `md` -> `h-5 w-5`
- `lg` -> `h-6 w-6`
- `xl` -> `h-7 w-7`

### 3.3 Estados y clases adicionales

- `state=valid` agrega `border-emerald-500 text-emerald-600`
- `state=invalid` agrega `border-rose-500 text-rose-600`
- `state=loading` agrega `opacity-75 animate-pulse`
- `interact_state.focused=true` agrega `ring-2`
- `interact_state.pressed=true` agrega `scale-95`
- si el usuario pasa `class` en atributos, se hace merge con las clases resueltas

### 3.4 Atributos HTML resueltos

El resolver también fija atributos:

- `type`: `checkbox`
- `name`, `id`, `value`: respetan prioridad de contexto/atributos
- `checked`: `true` cuando `checked=true` y `indeterminate=false`
- `disabled`: `true` cuando el estado es `disabled` o `loading`
- `readonly`: `true` cuando el estado es `readonly`
- `aria-invalid`: `'true'` cuando el estado es `invalid`
- `aria-busy`: `'true'` cuando el estado es `loading`
- `aria-checked`: `'mixed'` si indeterminate, `'true'`/`'false'` en caso normal
- `data-indeterminate`, `data-focused`, `data-hovered`, `data-pressed`: derivados de contexto/interact state

## 4. 🖥️ Formas de renderizar Tailwind CheckBox

Nota de uso de tema:

- Usa `theme="tailwind"` en `x-w4-checkbox` cuando el tema global de tu proyecto no sea Tailwind y quieras forzar Tailwind solo para ese checkbox.
- Usa `->theme('tailwind')` en `CheckBox::make(...)` cuando renderizas por helper/facade/controlador y quieres forzar Tailwind en esa instancia.
- Si tu configuración global ya está en Tailwind (`W4_UI_THEME=tailwind`), no es obligatorio repetir `theme="tailwind"` ni `->theme('tailwind')`.
- Mantén `theme="tailwind"` o `->theme('tailwind')` en ejemplos de documentación cuando quieras que el snippet sea explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Acepto términos')
        ->theme('tailwind')
        ->name('terms')
        ->checked(true)
        ->variant('primary')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\Forms\CheckBox\CheckBox;

echo W4Ui::render(
    CheckBox::make('Recibir notificaciones')
        ->theme('tailwind')
        ->name('notifications')
        ->variant('info')
        ->size('sm')
);
```

### 4.3 Componente Blade directo (`x-w4-checkbox`)

```blade
<x-w4-checkbox
    label="Acepto términos"
    theme="tailwind"
    name="terms"
    value="1"
    variant="primary"
    size="md"
    :checked="true"
/>
```

Parámetros Blade comunes:

- `label`
- `id`
- `name`
- `theme`
- `renderer`
- `value`
- `helperText`
- `errorMessage`
- `variant`
- `size`
- `checked`
- `indeterminate`
- `disabled`
- `loading`
- `readonly`
- `invalid`
- `valid`
- `focused`
- `hovered`
- `pressed`
- `class`

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Activo')
        ->theme('tailwind')
        ->state(\W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Bloqueado')
        ->theme('tailwind')
        ->state(\W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentState::DISABLED)
);
```

Render helper con estado `invalid`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Aceptación requerida')
        ->theme('tailwind')
        ->state(\W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentState::INVALID)
);
```

Render helper con indeterminado:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Selección parcial')
        ->theme('tailwind')
        ->setIndeterminate()
);
```

Render por evento `toggle`:

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Alternar')
        ->theme('tailwind')
        ->dispatch(CheckBoxComponentEvent::TOGGLE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentEvent;

$checkbox = \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Reset')
    ->theme('tailwind')
    ->dispatch(CheckBoxComponentEvent::SET_INVALID)
    ->dispatch(CheckBoxComponentEvent::RESET);

echo w4_render($checkbox);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-checkbox`)

```blade
<x-w4-checkbox label="Marcado" theme="tailwind" :checked="true" />
<x-w4-checkbox label="Deshabilitado" theme="tailwind" :disabled="true" />
<x-w4-checkbox label="Inválido" theme="tailwind" :invalid="true" errorMessage="Debes aceptarlo" />
```

Para volver al estado base (`reset`) en Blade, renderiza el checkbox sin `:invalid`, `:loading`, `:disabled` ni `:readonly`.

## 5. 🧭 Ejemplos prácticos Tailwind

Checkbox de términos:

```blade
<x-w4-checkbox
    label="Acepto términos y condiciones"
    name="terms"
    theme="tailwind"
    variant="primary"
    :checked="true"
/>
```

Checkbox con ayuda:

```blade
<x-w4-checkbox
    label="Recibir novedades"
    name="newsletter"
    theme="tailwind"
    helperText="Puedes desuscribirte cuando quieras"
    variant="info"
/>
```

Checkbox con `componentId` para auditoría/estado:

```blade
<x-w4-checkbox
    label="Checkbox auditado"
    theme="tailwind"
    :componentId="'checkbox-9003'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Audit')
        ->theme('tailwind')
        ->meta('component_id', 'checkbox-9003')
        ->attribute('data-component-id', 'checkbox-9003')
);
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\Forms\CheckBox\CheckBox;
use W4\UiFramework\Facades\W4Ui;

class RegisterController extends Controller
{
    public function create(): View
    {
        $termsCheck = CheckBox::make('Acepto términos')
            ->name('terms')
            ->id('chk-terms')
            ->theme('tailwind')
            ->value('1')
            ->variant('primary')
            ->size('md');

        return view('auth.register', [
            'termsCheckHtml' => W4Ui::render($termsCheck),
        ]);
    }
}
```

En la vista:

```blade
{!! $termsCheckHtml !!}
```

## 7. 📦 Notas de integración

- El Tailwind CheckBox usa el mismo payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `tailwind` (global o por componente).
- Si usas purge en Tailwind, asegúrate de incluir clases `border-*`, `text-*`, `focus:ring-*`, `ring-2`, `scale-95` y `animate-pulse` en el escaneo/safelist de tu app consumidora.
