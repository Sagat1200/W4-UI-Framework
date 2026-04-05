# 🚀 W4-UI-Framework

## ✨ Contexto del componente Daisy FieldError

## 1. 📌 Información General

`Daisy FieldError` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\Forms\FielError\FieldError`

y aplica estilos/atributos a través del resolver DaisyUI:

`W4\UiFramework\Themes\DaisyUI\Components\Forms\FieldErrorThemeResolver`

Esto significa que toda la API funcional del field-error base se conserva, y el tema DaisyUI define cómo se ven variantes, tamaños, estados e interacción visual.

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
    ->theme('daisyui')
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
    ->theme('daisyui')
    ->dispatch(FieldErrorComponentEvent::ACTIVATE);
```

## 3. 🎨 Resolución visual DaisyUI (ThemeResolver)

Según `FieldErrorThemeResolver`, Daisy FieldError usa clases base:

- `label-text-alt`
- `text-error`

### 3.1 Variantes Daisy disponibles

Mapeo actual de `variant`:

- `neutral` -> `text-base-content`
- `primary` -> `text-primary`
- `secondary` -> `text-secondary`
- `accent` -> `text-accent`
- `success` -> `text-success`
- `warning` -> `text-warning`
- `info` -> `text-info`
- `danger` o `error` -> `text-error`
- valor no reconocido -> `text-error`

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

El resolver también fija atributos:

- `role`: usa el del usuario o `alert` por defecto
- `aria-live`: `assertive` cuando el estado es `active`; `polite` en los demás estados
- `aria-hidden`: `'true'` cuando el estado es `hidden`
- `data-state`: estado actual del componente
- `data-for-field`: valor de `forField` cuando existe
- `data-error-code`: valor de `code` cuando existe

## 4. 🖥️ Formas de renderizar Daisy FieldError

Nota de uso de tema:

- Usa `theme="daisyui"` en `x-w4-field-error` cuando el tema global de tu proyecto no sea DaisyUI y quieras forzar Daisy solo para ese field-error.
- Usa `->theme('daisyui')` en `FieldError::make(...)` cuando renderizas por helper/facade/controlador y quieres forzar Daisy en esa instancia.
- Si tu configuración global ya está en DaisyUI (`W4_UI_THEME=daisyui`), no es obligatorio repetir `theme="daisyui"` ni `->theme('daisyui')`.
- Mantén `theme="daisyui"` o `->theme('daisyui')` en ejemplos de documentación cuando quieras un snippet explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Campo requerido')
        ->theme('daisyui')
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
        ->theme('daisyui')
        ->message('La contraseña es muy corta')
        ->code('E_PASSWORD_LENGTH')
        ->variant('warning')
        ->size('sm')
);
```

### 4.3 Componente Blade directo (`x-w4-field-error`)

```blade
<x-w4-field-error
    theme="daisyui"
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
        ->theme('daisyui')
        ->state(\W4\UiFramework\Components\Forms\FielError\FieldErrorComponentState::ENABLED)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Campo requerido')
        ->theme('daisyui')
        ->state(\W4\UiFramework\Components\Forms\FielError\FieldErrorComponentState::ACTIVE)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Campo requerido')
        ->theme('daisyui')
        ->state(\W4\UiFramework\Components\Forms\FielError\FieldErrorComponentState::DISABLED)
);
```

Render por evento `activate`:

```php
use W4\UiFramework\Components\Forms\FielError\FieldErrorComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Error activo')
        ->theme('daisyui')
        ->dispatch(FieldErrorComponentEvent::ACTIVATE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\Forms\FielError\FieldErrorComponentEvent;

$fieldError = \W4\UiFramework\Components\Forms\FielError\FieldError::make('Reset')
    ->theme('daisyui')
    ->dispatch(FieldErrorComponentEvent::ACTIVATE)
    ->dispatch(FieldErrorComponentEvent::RESET);

echo w4_render($fieldError);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-field-error`)

```blade
<x-w4-field-error message="Error activo" theme="daisyui" :active="true" />
<x-w4-field-error message="Error deshabilitado" theme="daisyui" :disabled="true" />
<x-w4-field-error message="Error oculto" theme="daisyui" :hidden="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el field-error sin `:active`, `:disabled` ni `:hidden`.

## 5. 🧭 Ejemplos prácticos Daisy

Error de campo requerido:

```blade
<x-w4-field-error
    message="El correo es obligatorio"
    forField="email"
    code="E_REQUIRED"
    theme="daisyui"
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
    theme="daisyui"
    variant="warning"
/>
```

Error con `componentId` para auditoría/estado:

```blade
<x-w4-field-error
    message="Error auditado"
    theme="daisyui"
    :componentId="'field-error-9002'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\Forms\FielError\FieldError::make('Audit')
        ->theme('daisyui')
        ->meta('component_id', 'field-error-9002')
        ->attribute('data-component-id', 'field-error-9002')
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
            ->theme('daisyui')
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

- El Daisy FieldError usa el mismo payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `daisyui` (global o por componente).
- Si usas purge en Tailwind/DaisyUI, asegúrate de incluir clases `label-text-alt`, `text-*`, `font-semibold`, `hidden` y `opacity-50` en el escaneo/safelist de tu app consumidora.
