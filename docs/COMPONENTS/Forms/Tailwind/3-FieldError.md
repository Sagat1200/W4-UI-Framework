# 🚀 W4-UI-Framework

## ✨ Contexto del componente Tailwind FieldError

## 1. 📌 Información General

`Tailwind FieldError` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\Forms\FielError\FieldError`

y aplica estilos/atributos a través del resolver Tailwind:

`W4\UiFramework\Themes\Tailwind\Components\Forms\FieldErrorThemeResolver`

Esto significa que toda la API funcional del field-error base se conserva, y el tema Tailwind define cómo se ven variantes, tamaños, estados e interacción visual.

## 2. 🧱 API base del FieldError (heredada)

Creación base:

```php
use W4\UiFramework\Components\Forms\FielError\FieldError;

$fieldError = FieldError::make('Campo requerido');
```

Fluent API más usada:

```php
use W4\UiFramework\Components\Forms\FielError\FieldErrorComponentEvent;

$fieldError = FieldError::make('Campo requerido')
    ->name('email_error')
    ->id('field-error-email')
    ->theme('tailwind')
    ->message('El correo es obligatorio')
    ->forField('email')
    ->code('E_REQUIRED')
    ->hint('Completa el campo para continuar')
    ->variant('error')
    ->size('sm')
    ->dispatch(FieldErrorComponentEvent::ACTIVATE);
```

Estados funcionales soportados:

- `enabled`
- `disabled`
- `active`
- `hidden`

Eventos soportados por la state machine del field-error:

- `activate`
- `deactivate`
- `disable`
- `enable`
- `hide`
- `show`
- `reset`

Métodos de conveniencia disponibles:

- `activate()`
- `deactivate()`
- `disable()`
- `enable()`
- `hide()`
- `show()`
- `resetState()`
- `can(FieldErrorComponentEvent $event)`
- `dispatch(FieldErrorComponentEvent $event)`

Ejemplo de transición por evento:

```php
use W4\UiFramework\Components\Forms\FielError\FieldErrorComponentEvent;

$fieldError = FieldError::make('Campo requerido')
    ->theme('tailwind')
    ->dispatch(FieldErrorComponentEvent::ACTIVATE);
```

## 3. 🎨 Resolución visual Tailwind (ThemeResolver)

Según `FieldErrorThemeResolver`, Tailwind FieldError usa clases base:

- `mt-1`
- `block`
- `text-rose-600`

### 3.1 Variantes Tailwind disponibles

Mapeo actual de `variant`:

- `neutral` -> `text-slate-600`
- `primary` -> `text-blue-600`
- `secondary` -> `text-slate-700`
- `accent` -> `text-violet-600`
- `success` -> `text-emerald-600`
- `warning` -> `text-amber-600`
- `info` -> `text-cyan-600`
- `danger` o `error` -> `text-rose-600`
- valor no reconocido -> `text-rose-600`

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

El resolver también fija atributos:

- `role`: usa el del usuario o `alert` por defecto
- `aria-live`: `assertive` cuando el estado es `active`; `polite` en los demás estados
- `aria-hidden`: `'true'` cuando el estado es `hidden`
- `data-state`: estado actual del componente
- `data-for-field`: valor de `forField` cuando existe
- `data-error-code`: valor de `code` cuando existe

## 4. 🖥️ Formas de renderizar Tailwind FieldError

Nota de uso de tema:

- Usa `theme="tailwind"` en `x-w4-field-error` cuando el tema global de tu proyecto no sea Tailwind y quieras forzar Tailwind solo para ese field-error.
- Usa `->theme('tailwind')` en `FieldError::make(...)` cuando renderizas por helper/facade/controlador y quieres forzar Tailwind en esa instancia.
- Si tu configuración global ya está en Tailwind (`W4_UI_THEME=tailwind`), no es obligatorio repetir `theme="tailwind"` ni `->theme('tailwind')`.
- Mantén `theme="tailwind"` o `->theme('tailwind')` en ejemplos de documentación cuando quieras un snippet explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Campo requerido')
        ->theme('tailwind')
        ->message('El correo es obligatorio')
        ->forField('email')
        ->variant('error')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\Forms\FielError\FieldError;

echo W4Ui::render(
    FieldError::make('Error de contraseña')
        ->theme('tailwind')
        ->message('La contraseña es muy corta')
        ->code('E_PASSWORD_LENGTH')
        ->variant('warning')
        ->size('sm')
);
```

### 4.3 Componente Blade directo (`x-w4-field-error`)

```blade
<x-w4-field-error
    theme="tailwind"
    message="El correo es obligatorio"
    forField="email"
    code="E_REQUIRED"
    hint="Revisa este campo"
    variant="error"
    size="sm"
    :active="true"
/>
```

Parámetros Blade comunes:

- `label`
- `id`
- `name`
- `theme`
- `renderer`
- `message`
- `forField`
- `code`
- `hint`
- `variant`
- `size`
- `active`
- `disabled`
- `hidden`
- `focused`
- `hovered`
- `class`

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Campo requerido')
        ->theme('tailwind')
        ->state(\W4\UiFramework\Components\Forms\FielError\FieldErrorComponentState::ENABLED)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Campo requerido')
        ->theme('tailwind')
        ->state(\W4\UiFramework\Components\Forms\FielError\FieldErrorComponentState::ACTIVE)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Campo requerido')
        ->theme('tailwind')
        ->state(\W4\UiFramework\Components\Forms\FielError\FieldErrorComponentState::DISABLED)
);
```

Render por evento `activate`:

```php
use W4\UiFramework\Components\Forms\FielError\FieldErrorComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Error activo')
        ->theme('tailwind')
        ->dispatch(FieldErrorComponentEvent::ACTIVATE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\Forms\FielError\FieldErrorComponentEvent;

$fieldError = \W4\UiFramework\Components\Forms\FielError\FieldError::make('Reset')
    ->theme('tailwind')
    ->dispatch(FieldErrorComponentEvent::ACTIVATE)
    ->dispatch(FieldErrorComponentEvent::RESET);

echo w4_render($fieldError);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-field-error`)

```blade
<x-w4-field-error message="Error activo" theme="tailwind" :active="true" />
<x-w4-field-error message="Error deshabilitado" theme="tailwind" :disabled="true" />
<x-w4-field-error message="Error oculto" theme="tailwind" :hidden="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el field-error sin `:active`, `:disabled` ni `:hidden`.

## 5. 🧭 Ejemplos prácticos Tailwind

Error de campo requerido:

```blade
<x-w4-field-error
    message="El correo es obligatorio"
    forField="email"
    code="E_REQUIRED"
    theme="tailwind"
    variant="error"
    :active="true"
/>
```

Error con hint:

```blade
<x-w4-field-error
    message="La contraseña es muy corta"
    code="E_PASSWORD_LENGTH"
    hint="Debe tener al menos 8 caracteres"
    theme="tailwind"
    variant="warning"
/>
```

Error con `componentId` para auditoría/estado:

```blade
<x-w4-field-error
    message="Error auditado"
    theme="tailwind"
    :componentId="'field-error-9003'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Audit')
        ->theme('tailwind')
        ->meta('component_id', 'field-error-9003')
        ->attribute('data-component-id', 'field-error-9003')
);
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\Forms\FielError\FieldError;
use W4\UiFramework\Facades\W4Ui;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $emailError = FieldError::make('El correo es obligatorio')
            ->name('email_error')
            ->id('field-error-email')
            ->theme('tailwind')
            ->forField('email')
            ->code('E_REQUIRED')
            ->hint('Completa este campo')
            ->variant('error')
            ->size('sm')
            ->activate();

        return view('profile.edit', [
            'emailErrorHtml' => W4Ui::render($emailError),
        ]);
    }
}
```

En la vista:

```blade
{!! $emailErrorHtml !!}
```

## 7. 📦 Notas de integración

- El Tailwind FieldError usa el mismo payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `tailwind` (global o por componente).
- Si usas purge en Tailwind, asegúrate de incluir clases `text-*`, `font-semibold`, `hidden`, `opacity-50` y `mt-1` en el escaneo/safelist de tu app consumidora.
