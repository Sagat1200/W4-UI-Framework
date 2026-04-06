# 🚀 W4-UI-Framework

## ✨ Contexto del componente Tailwind HelperText

## 1. 📌 Información General

`Tailwind HelperText` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\Forms\HelperText\HelperText`

y aplica estilos/atributos a través del resolver Tailwind:

`W4\UiFramework\Themes\Tailwind\Components\Forms\HelperTextThemeResolver`

Esto significa que toda la API funcional del helper-text base se conserva, y el tema Tailwind define cómo se ven variantes, tamaños, estados e interacción visual.

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
    ->theme('tailwind')
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

## 3. 🎨 Resolución visual Tailwind (ThemeResolver)

Según `HelperTextThemeResolver`, Tailwind HelperText usa clases base:

- `mt-1`
- `block`

### 3.1 Variantes Tailwind disponibles

Mapeo actual de `variant`:

- `neutral` y `default` -> `text-slate-500`
- `primary` -> `text-blue-600`
- `secondary` -> `text-slate-700`
- `accent` -> `text-violet-600`
- `success` -> `text-emerald-600`
- `warning` -> `text-amber-600`
- `error` o `danger` -> `text-rose-600`
- `info` -> `text-cyan-600`

### 3.2 Tamaños Tailwind disponibles

Mapeo actual de `size`:

- `xs` -> `text-xs`
- `sm` -> `text-sm`
- `md` -> `text-base`
- `lg` -> `text-lg`
- `xl` -> `text-xl`

### 3.3 Estados y clases adicionales

- `state=disabled` agrega `opacity-50`
- `state=active` agrega `font-medium`
- `state=hidden` agrega `hidden`
- si el usuario pasa `class` en atributos, se hace merge con las clases resueltas

### 3.4 Atributos HTML resueltos

- `role`: usa el del usuario o `note`
- `aria-live`: `polite` cuando `active`; `off` en otro estado
- `aria-hidden`: `'true'` cuando `hidden`
- `data-state`: estado actual
- `data-for-field`: valor de `forField`
- `data-focused`, `data-hovered`: desde `interact_state`

## 4. 🖥️ Formas de renderizar Tailwind HelperText

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\HelperText\HelperText::make('Puedes usar 8+ caracteres')
        ->theme('tailwind')
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
        ->theme('tailwind')
        ->forField('username')
        ->variant('neutral')
);
```

### 4.3 Componente Blade directo (`x-w4-helper-text`)

```blade
<x-w4-helper-text
    theme="tailwind"
    text="Puedes usar 8+ caracteres"
    forField="password"
    icon="ℹ"
    variant="info"
    size="sm"
    :active="true"
/>
```

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\HelperText\HelperText::make('Ayuda base')
        ->theme('tailwind')
        ->state(\W4\UiFramework\Components\Forms\HelperText\HelperTextComponentState::ENABLED)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\HelperText\HelperText::make('Ayuda activa')
        ->theme('tailwind')
        ->state(\W4\UiFramework\Components\Forms\HelperText\HelperTextComponentState::ACTIVE)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\HelperText\HelperText::make('Ayuda deshabilitada')
        ->theme('tailwind')
        ->state(\W4\UiFramework\Components\Forms\HelperText\HelperTextComponentState::DISABLED)
);
```

Render por evento `activate`:

```php
use W4\UiFramework\Components\Forms\HelperText\HelperTextComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\HelperText\HelperText::make('Ayuda activada')
        ->theme('tailwind')
        ->dispatch(HelperTextComponentEvent::ACTIVATE)
);
```

Render por evento `hide`:

```php
use W4\UiFramework\Components\Forms\HelperText\HelperTextComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\HelperText\HelperText::make('Ayuda oculta')
        ->theme('tailwind')
        ->dispatch(HelperTextComponentEvent::HIDE)
);
```

Render por evento `reset` después de activar:

```php
use W4\UiFramework\Components\Forms\HelperText\HelperTextComponentEvent;

$helperText = \W4\UiFramework\Components\Forms\HelperText\HelperText::make('Reset')
    ->theme('tailwind')
    ->dispatch(HelperTextComponentEvent::ACTIVATE)
    ->dispatch(HelperTextComponentEvent::RESET);

echo w4_render($helperText);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-helper-text`)

```blade
<x-w4-helper-text text="Activo" theme="tailwind" :active="true" />
<x-w4-helper-text text="Deshabilitado" theme="tailwind" :disabled="true" />
<x-w4-helper-text text="Oculto" theme="tailwind" :hidden="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el helper-text sin `:active`, `:disabled` ni `:hidden`.

### 4.6 Auditoría con componentId

```blade
<x-w4-helper-text
    text="Helper auditado"
    theme="tailwind"
    :componentId="'helper-text-9003'"
/>
```

## 5. 🧭 Ejemplos prácticos Tailwind

Ayuda para contraseña:

```blade
<x-w4-helper-text
    text="Debe tener al menos 8 caracteres"
    forField="password"
    theme="tailwind"
    variant="info"
/>
```

Ayuda neutral:

```blade
<x-w4-helper-text
    text="Formato: nombre.apellido"
    forField="username"
    theme="tailwind"
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
            ->theme('tailwind')
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

- El Tailwind HelperText usa el mismo payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `tailwind` (global o por componente).
- Si usas purge en Tailwind, asegúrate de incluir clases `text-*`, `font-medium`, `hidden`, `opacity-50` y `mt-1`.
