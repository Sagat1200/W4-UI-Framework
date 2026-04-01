# 🚀 W4-UI-Framework

## ✨ Contexto del componente Input

## 1. 📌 Información General

`Input` es un componente UI base del paquete `w4/ui-framework` orientado a campos de formulario.

Abstrae:

- identidad (`id`, `name`)
- etiqueta (`label`)
- atributos HTML (`attributes`)
- metadata (`meta`)
- tipo de input (`type`)
- valor (`value`)
- placeholder (`placeholder`)
- texto de ayuda (`helper_text`)
- mensaje de error (`error_message`)
- estado funcional (`state`)
- estado de interacción (`interact_state`)
- tema (`theme`)
- tamaño (`size`)
- variante visual (`variant`)

Clase principal:

`W4\UiFramework\Components\UI\Input\Input`

## 2. 🧱 API del Componente

Creación base:

```php
use W4\UiFramework\Components\UI\Input\Input;

$input = Input::make('Correo');
```

Fluent API más usada:

```php
use W4\UiFramework\Components\UI\Input\InputComponentState;

$input = Input::make('Correo')
    ->name('email')
    ->id('input-email')
    ->type('email')
    ->value('user@example.com')
    ->placeholder('correo@dominio.com')
    ->helperText('Usaremos este correo para notificaciones')
    ->variant('default')
    ->size('md')
    ->state(InputComponentState::ENABLED)
    ->attribute('autocomplete', 'email')
    ->meta('field', 'contact_email');
```

Métodos específicos del componente:

- `type(...)`
- `value(...)`
- `placeholder(...)`
- `helperText(...)`
- `errorMessage(...)`
- `interactState(...)`

Atajos heredados de variante:

- `primary()`
- `secondary()`
- `success()`
- `danger()`
- `warning()`
- `info()`

Atajos heredados de tamaño:

- `xs()`
- `sm()`
- `md()`
- `lg()`
- `xl()`

Estados soportados por `InputComponentState`:

- `enabled`
- `disabled`
- `readonly`
- `invalid`
- `valid`
- `loading`

Estado de interacción:

```php
use W4\UiFramework\Components\UI\Input\InputInteractState;

$input->interactState(new InputInteractState(
    focused: true,
    hovered: false,
    filled: true
));
```

## 3. 🎨 Variantes por Tema

`Input` delega clases y atributos HTML al `ThemeResolver`.

Bootstrap (`BootstrapTheme`):

- base: `form-control`
- tamaños: `sm`, `md`, `lg`
- variantes visuales: `success`, `danger/error`, `warning`
- estados: `valid`, `invalid`, `loading`, `disabled`, `readonly`

DaisyUI (`DaisyTheme`):

- base: `input input-bordered w-full`
- tamaños: `xs`, `sm`, `md`, `lg`
- variantes visuales: `primary`, `secondary`, `accent`, `success`, `warning`, `danger/error`
- estados: `valid`, `invalid`, `loading`, `disabled`, `readonly`

## 4. 🖥️ Formas de Renderizar el Input

### 4.1 Helper global (`w4_render`)

```php
use W4\UiFramework\Components\UI\Input\Input;

echo w4_render(
    Input::make('Nombre')->name('name')->placeholder('Tu nombre')
);
```

### 4.2 Facade (`W4Ui`)

```php
use W4\UiFramework\Components\UI\Input\Input;
use W4\UiFramework\Facades\W4Ui;

echo W4Ui::render(
    Input::make('Correo')->type('email')->name('email')->attribute('required', true)
);
```

### 4.3 Componente Blade genérico (`x-w4-render`)

```php
@php
    $input = \W4\UiFramework\Components\UI\Input\Input::make('Usuario')
        ->name('username')
        ->placeholder('usuario');
@endphp

<x-w4-render :component="$input" />
```

### 4.4 Componente Blade directo (`x-w4-input`)

```blade
<x-w4-input
    label="Correo"
    name="email"
    type="email"
    placeholder="correo@dominio.com"
    variant="default"
    size="md"
/>
```

Parámetros Blade más comunes en `x-w4-input`:

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
- `readonly`

### 4.5 Vista/payload para integración avanzada

```php
use W4\UiFramework\Components\UI\Input\Input;
use W4\UiFramework\Components\UI\Input\InputComponentState;
use W4\UiFramework\Facades\W4Ui;

$input = Input::make('Código')
    ->name('code')
    ->state(InputComponentState::INVALID)
    ->errorMessage('Código inválido');

$view = W4Ui::view($input);
$payload = W4Ui::payload($input);
```

`payload` retorna datos normalizados (`renderer`, `view`, `data`, `theme`) para inspección o bridges.

### 4.6 Ejemplo de uso dentro de un controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\UI\Input\Input;
use W4\UiFramework\Components\UI\Input\InputComponentState;
use W4\UiFramework\Facades\W4Ui;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $emailInput = Input::make('Correo')
            ->name('email')
            ->id('input-email')
            ->type('email')
            ->placeholder('correo@dominio.com')
            ->state(InputComponentState::ENABLED);

        return view('profile.edit', [
            'emailInputHtml' => W4Ui::render($emailInput),
        ]);
    }
}
```

En la vista `resources/views/profile/edit.blade.php`:

```blade
<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PUT')
    {!! $emailInputHtml !!}
</form>
```

## 5. 🔧 Personalización por atributo y tema

Ejemplo con DaisyUI, estado inválido y clases extra:

```php
use W4\UiFramework\Components\UI\Input\Input;
use W4\UiFramework\Components\UI\Input\InputComponentState;

$input = Input::make('Teléfono')
    ->theme('daisyui')
    ->variant('warning')
    ->state(InputComponentState::INVALID)
    ->errorMessage('Formato no válido')
    ->attribute('class', 'max-w-md')
    ->attribute('inputmode', 'numeric');

echo w4_render($input);
```

## 6. 📦 Salida Blade base del paquete

La vista por defecto del input es:

`resources/views/input.blade.php`

El renderer Blade del core apunta a:

`w4-ui::input`

El template renderiza:

- `label` si existe
- `<input ...>` con atributos resueltos por tema
- `helper_text` cuando no hay error
- `error_message` cuando el estado o validación lo requiere
