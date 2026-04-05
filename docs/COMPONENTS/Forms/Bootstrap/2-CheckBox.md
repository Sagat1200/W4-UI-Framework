# 🚀 W4-UI-Framework

## ✨ Contexto del componente Bootstrap CheckBox

## 1. 📌 Información General

`Bootstrap CheckBox` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\Forms\CheckBox\CheckBox`

y aplica estilos/atributos a través del resolver Bootstrap:

`W4\UiFramework\Themes\Bootstrap\Components\Forms\CheckBoxThemeResolver`

Esto significa que toda la API funcional del checkbox base se conserva, y el tema Bootstrap define cómo se ven variantes, tamaños, estados e interacción visual.

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
    ->theme('bootstrap')
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
    ->theme('bootstrap')
    ->dispatch(CheckBoxComponentEvent::SET_INVALID);
```

## 3. 🎨 Resolución visual Bootstrap (ThemeResolver)

Según `CheckBoxThemeResolver`, Bootstrap CheckBox usa clase base:

- `form-check-input`

### 3.1 Variantes Bootstrap disponibles

Mapeo actual de `variant`:

- `success` -> `is-valid`
- `danger` o `error` -> `is-invalid`
- `warning` -> `border-warning`
- otras variantes no agregan clase específica adicional

### 3.2 Tamaños Bootstrap disponibles

Mapeo actual de `size`:

- `sm` -> `form-check-input-sm`
- `md` -> sin clase adicional
- `lg` -> `form-check-input-lg`

### 3.3 Estados y clases adicionales

- `state=valid` agrega `is-valid`
- `state=invalid` agrega `is-invalid`
- `state=loading` agrega `opacity-75`
- `interact_state.focused=true` agrega `focus`
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

## 4. 🖥️ Formas de renderizar Bootstrap CheckBox

Nota de uso de tema:

- Usa `theme="bootstrap"` en `x-w4-checkbox` cuando el tema global de tu proyecto no sea Bootstrap y quieras forzar Bootstrap solo para ese checkbox.
- Usa `->theme('bootstrap')` en `CheckBox::make(...)` cuando renderizas por helper/facade/controlador y quieres forzar Bootstrap en esa instancia.
- Si tu configuración global ya está en Bootstrap (`W4_UI_THEME=bootstrap`), no es obligatorio repetir `theme="bootstrap"` ni `->theme('bootstrap')`.
- Mantén `theme="bootstrap"` o `->theme('bootstrap')` en ejemplos de documentación cuando quieras que el snippet sea explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Acepto términos')
        ->theme('bootstrap')
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
        ->theme('bootstrap')
        ->name('notifications')
        ->variant('warning')
        ->size('sm')
);
```

### 4.3 Componente Blade directo (`x-w4-checkbox`)

```blade
<x-w4-checkbox
    label="Acepto términos"
    theme="bootstrap"
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
        ->theme('bootstrap')
        ->state(\W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Bloqueado')
        ->theme('bootstrap')
        ->state(\W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentState::DISABLED)
);
```

Render helper con estado `invalid`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Aceptación requerida')
        ->theme('bootstrap')
        ->state(\W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentState::INVALID)
);
```

Render helper con indeterminado:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Selección parcial')
        ->theme('bootstrap')
        ->setIndeterminate()
);
```

Render por evento `toggle`:

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Alternar')
        ->theme('bootstrap')
        ->dispatch(CheckBoxComponentEvent::TOGGLE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentEvent;

$checkbox = \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Reset')
    ->theme('bootstrap')
    ->dispatch(CheckBoxComponentEvent::SET_INVALID)
    ->dispatch(CheckBoxComponentEvent::RESET);

echo w4_render($checkbox);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-checkbox`)

```blade
<x-w4-checkbox label="Marcado" theme="bootstrap" :checked="true" />
<x-w4-checkbox label="Deshabilitado" theme="bootstrap" :disabled="true" />
<x-w4-checkbox label="Inválido" theme="bootstrap" :invalid="true" errorMessage="Debes aceptarlo" />
```

Para volver al estado base (`reset`) en Blade, renderiza el checkbox sin `:invalid`, `:loading`, `:disabled` ni `:readonly`.

## 5. 🧭 Ejemplos prácticos Bootstrap

Checkbox de términos:

```blade
<x-w4-checkbox
    label="Acepto términos y condiciones"
    name="terms"
    theme="bootstrap"
    variant="primary"
    :checked="true"
/>
```

Checkbox con ayuda:

```blade
<x-w4-checkbox
    label="Recibir novedades"
    name="newsletter"
    theme="bootstrap"
    helperText="Puedes desuscribirte cuando quieras"
    variant="warning"
/>
```

Checkbox con `componentId` para auditoría/estado:

```blade
<x-w4-checkbox
    label="Checkbox auditado"
    theme="bootstrap"
    :componentId="'checkbox-9001'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\Forms\CheckBox\CheckBox::make('Audit')
        ->theme('bootstrap')
        ->meta('component_id', 'checkbox-9001')
        ->attribute('data-component-id', 'checkbox-9001')
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
            ->theme('bootstrap')
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

- El Bootstrap CheckBox usa el mismo payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `bootstrap` (global o por componente).
- Si usas optimización de CSS en producción, asegúrate de incluir clases `form-check-input*`, `is-valid`, `is-invalid`, `opacity-75` y `focus`.
