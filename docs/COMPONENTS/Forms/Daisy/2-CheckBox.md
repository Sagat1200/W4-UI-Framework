# 🚀 W4-UI-Framework

## ✨ Contexto del componente Daisy CheckBox

## 1. 📌 Información General

`Daisy CheckBox` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\Forms\CheckBox\CheckBox`

y aplica estilos/atributos a través del resolver DaisyUI:

`W4\UiFramework\Themes\DaisyUI\Components\Forms\CheckBoxThemeResolver`

Esto significa que toda la API funcional del checkbox base se conserva, y el tema DaisyUI define cómo se ven variantes, tamaños, estados e interacción visual.

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
    ->theme('daisyui')
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
    ->theme('daisyui')
    ->dispatch(CheckBoxComponentEvent::SET_INVALID);
```

## 3. 🎨 Resolución visual DaisyUI (ThemeResolver)

Según `CheckBoxThemeResolver`, Daisy CheckBox usa clase base:

- `checkbox`

### 3.1 Variantes Daisy disponibles

Mapeo actual de `variant`:

- `neutral` y `default` -> `checkbox-neutral`
- `primary` -> `checkbox-primary`
- `secondary` -> `checkbox-secondary`
- `accent` -> `checkbox-accent`
- `success` -> `checkbox-success`
- `warning` -> `checkbox-warning`
- `error` o `danger` -> `checkbox-error`
- `info` -> `checkbox-info`
- valor no reconocido -> `checkbox-neutral`

### 3.2 Tamaños Daisy disponibles

Mapeo actual de `size`:

- `xs` -> `checkbox-xs`
- `sm` -> `checkbox-sm`
- `md` -> `checkbox-md`
- `lg` -> `checkbox-lg`
- `xl` -> `checkbox-lg`

### 3.3 Estados y clases adicionales

- `state=valid` agrega `checkbox-success`
- `state=invalid` agrega `checkbox-error`
- `state=loading` agrega `opacity-75`
- `interact_state.focused=true` agrega `ring`
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

## 4. 🖥️ Formas de renderizar Daisy CheckBox

Nota de uso de tema:

- Usa `theme="daisyui"` en `x-w4-checkbox` cuando el tema global de tu proyecto no sea DaisyUI y quieras forzar Daisy solo para ese checkbox.
- Usa `->theme('daisyui')` en `CheckBox::make(...)` cuando renderizas por helper/facade/controlador y quieres forzar Daisy en esa instancia.
- Si tu configuración global ya está en DaisyUI (`W4_UI_THEME=daisyui`), no es obligatorio repetir `theme="daisyui"` ni `->theme('daisyui')`.
- Mantén `theme="daisyui"` o `->theme('daisyui')` en ejemplos de documentación cuando quieras que el snippet sea explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Acepto términos')
        ->theme('daisyui')
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
        ->theme('daisyui')
        ->name('notifications')
        ->variant('info')
        ->size('sm')
);
```

### 4.3 Componente Blade directo (`x-w4-checkbox`)

```blade
<x-w4-checkbox
    label="Acepto términos"
    theme="daisyui"
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
        ->theme('daisyui')
        ->state(\W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Bloqueado')
        ->theme('daisyui')
        ->state(\W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentState::DISABLED)
);
```

Render helper con estado `invalid`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Aceptación requerida')
        ->theme('daisyui')
        ->state(\W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentState::INVALID)
);
```

Render helper con indeterminado:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Selección parcial')
        ->theme('daisyui')
        ->setIndeterminate()
);
```

Render por evento `toggle`:

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Alternar')
        ->theme('daisyui')
        ->dispatch(CheckBoxComponentEvent::TOGGLE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentEvent;

$checkbox = \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Reset')
    ->theme('daisyui')
    ->dispatch(CheckBoxComponentEvent::SET_INVALID)
    ->dispatch(CheckBoxComponentEvent::RESET);

echo w4_render($checkbox);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-checkbox`)

```blade
<x-w4-checkbox label="Marcado" theme="daisyui" :checked="true" />
<x-w4-checkbox label="Deshabilitado" theme="daisyui" :disabled="true" />
<x-w4-checkbox label="Inválido" theme="daisyui" :invalid="true" errorMessage="Debes aceptarlo" />
```

Para volver al estado base (`reset`) en Blade, renderiza el checkbox sin `:invalid`, `:loading`, `:disabled` ni `:readonly`.

## 5. 🧭 Ejemplos prácticos Daisy

Checkbox de términos:

```blade
<x-w4-checkbox
    label="Acepto términos y condiciones"
    name="terms"
    theme="daisyui"
    variant="primary"
    :checked="true"
/>
```

Checkbox con ayuda:

```blade
<x-w4-checkbox
    label="Recibir novedades"
    name="newsletter"
    theme="daisyui"
    helperText="Puedes desuscribirte cuando quieras"
    variant="info"
/>
```

Checkbox con `componentId` para auditoría/estado:

```blade
<x-w4-checkbox
    label="Checkbox auditado"
    theme="daisyui"
    :componentId="'checkbox-9002'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Audit')
        ->theme('daisyui')
        ->meta('component_id', 'checkbox-9002')
        ->attribute('data-component-id', 'checkbox-9002')
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
            ->theme('daisyui')
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

- El Daisy CheckBox usa el mismo payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `daisyui` (global o por componente).
- Si usas purge en Tailwind/DaisyUI, asegúrate de incluir clases `checkbox*`, `ring`, `scale-95` y `opacity-75` en el escaneo/safelist de tu app consumidora.
