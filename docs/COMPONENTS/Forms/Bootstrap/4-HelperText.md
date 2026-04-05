# 🚀 W4-UI-Framework

## ✨ Contexto del componente Bootstrap HelperText

## 1. 📌 Información General

`Bootstrap HelperText` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\Forms\HelperText\HelperText`

y aplica estilos/atributos a través del resolver Bootstrap:

`W4\UiFramework\Themes\Bootstrap\Components\Forms\HelperTextThemeResolver`

Esto significa que toda la API funcional del helper-text base se conserva, y el tema Bootstrap define cómo se ven variantes, tamaños, estados e interacción visual.

## 2. 🧱 API base del HelperText (heredada)

Creación base:

```php
use W4\UiFramework\Components\Forms\HelperText\HelperText;

$helperText = HelperText::make('Puedes usar 8+ caracteres');
```

Fluent API más usada:

```php
use W4\UiFramework\Components\Forms\HelperText\HelperTextComponentEvent;

$helperText = HelperText::make('Puedes usar 8+ caracteres')
    ->name('password_help')
    ->id('helper-text-password')
    ->theme('bootstrap')
    ->text('Puedes usar 8+ caracteres')
    ->forField('password')
    ->icon('ℹ')
    ->variant('info')
    ->size('sm')
    ->dispatch(HelperTextComponentEvent::ACTIVATE);
```

Estados funcionales soportados:

- `enabled`
- `disabled`
- `active`
- `hidden`

Eventos soportados por la state machine del helper-text:

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
- `can(HelperTextComponentEvent $event)`
- `dispatch(HelperTextComponentEvent $event)`

## 3. 🎨 Resolución visual Bootstrap (ThemeResolver)

Según `HelperTextThemeResolver`, Bootstrap HelperText usa clase base:

- `form-text`

### 3.1 Variantes Bootstrap disponibles

Mapeo actual de `variant`:

- `neutral` y `default` -> `text-body-secondary`
- `primary` -> `text-primary`
- `secondary` -> `text-secondary`
- `accent` y `info` -> `text-info`
- `success` -> `text-success`
- `warning` -> `text-warning`
- `error` o `danger` -> `text-danger`

### 3.2 Tamaños Bootstrap disponibles

Mapeo actual de `size`:

- `xs` y `sm` -> `fs-6`
- `md` -> `fs-5`
- `lg` -> `fs-4`
- `xl` -> `fs-3`

### 3.3 Estados y clases adicionales

- `state=disabled` agrega `opacity-50`
- `state=active` agrega `fw-medium`
- `state=hidden` agrega `d-none`
- si el usuario pasa `class` en atributos, se hace merge con las clases resueltas

### 3.4 Atributos HTML resueltos

- `role`: usa el del usuario o `note`
- `aria-live`: `polite` cuando `active`; `off` en otro estado
- `aria-hidden`: `'true'` cuando `hidden`
- `data-state`: estado actual
- `data-for-field`: valor de `forField`
- `data-focused`, `data-hovered`: desde `interact_state`

## 4. 🖥️ Formas de renderizar Bootstrap HelperText

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\HelperText\HelperText::make('Puedes usar 8+ caracteres')
        ->theme('bootstrap')
        ->forField('password')
        ->variant('info')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\Forms\HelperText\HelperText;

echo W4Ui::render(
    HelperText::make('Formato sugerido: nombre.apellido')
        ->theme('bootstrap')
        ->forField('username')
        ->variant('neutral')
);
```

### 4.3 Componente Blade directo (`x-w4-helper-text`)

```blade
<x-w4-helper-text
    theme="bootstrap"
    text="Puedes usar 8+ caracteres"
    forField="password"
    icon="ℹ"
    variant="info"
    size="sm"
    :active="true"
/>
```

### 4.4 Estados en Blade

```blade
<x-w4-helper-text text="Activo" theme="bootstrap" :active="true" />
<x-w4-helper-text text="Deshabilitado" theme="bootstrap" :disabled="true" />
<x-w4-helper-text text="Oculto" theme="bootstrap" :hidden="true" />
```

### 4.5 Auditoría con componentId

```blade
<x-w4-helper-text
    text="Helper auditado"
    theme="bootstrap"
    :componentId="'helper-text-9001'"
/>
```

## 5. 🧭 Ejemplos prácticos Bootstrap

Ayuda para contraseña:

```blade
<x-w4-helper-text
    text="Debe tener al menos 8 caracteres"
    forField="password"
    theme="bootstrap"
    variant="info"
/>
```

Ayuda neutral:

```blade
<x-w4-helper-text
    text="Formato: nombre.apellido"
    forField="username"
    theme="bootstrap"
    variant="neutral"
/>
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\Forms\HelperText\HelperText;
use W4\UiFramework\Facades\W4Ui;

class AccountController extends Controller
{
    public function edit(): View
    {
        $passwordHelp = HelperText::make('Debe tener al menos 8 caracteres')
            ->name('password_help')
            ->id('helper-text-password')
            ->theme('bootstrap')
            ->forField('password')
            ->icon('ℹ')
            ->variant('info')
            ->size('sm')
            ->activate();

        return view('account.edit', [
            'passwordHelpHtml' => W4Ui::render($passwordHelp),
        ]);
    }
}
```

En la vista:

```blade
{!! $passwordHelpHtml !!}
```

## 7. 📦 Notas de integración

- El Bootstrap HelperText usa el mismo payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `bootstrap` (global o por componente).
- Si usas optimización de CSS en producción, asegúrate de incluir clases `form-text`, `text-*`, `d-none`, `opacity-50` y `fw-medium`.
