# 🚀 W4-UI-Framework

## ✨ Contexto del componente Button

## 1. 📌 Información General

`Button` es un componente UI base del paquete `w4/ui-framework` que abstrae:

- identidad (`id`, `name`)
- etiqueta (`label`)
- atributos HTML (`attributes`)
- metadata (`meta`)
- estado funcional (`state`)
- estado de interacción (`interact_state`)
- tema (`theme`)
- tamaño (`size`)
- variante visual (`variant`)

Clase principal:

`W4\UiFramework\Components\UI\Button\Button`

## 2. 🧱 API del Componente

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
    ->variant('primary')
    ->size('md')
    ->state(\W4\UiFramework\Components\UI\Button\ButtonComponentState::ENABLED)
    ->attribute('data-action', 'save')
    ->meta('permission', 'orders.update');
```

Atajos de variante:

- `primary()`
- `secondary()`
- `success()`
- `danger()`
- `warning()`
- `info()`

Atajos de tamaño:

- `xs()`
- `sm()`
- `md()`
- `lg()`
- `xl()`

Estados soportados por `ButtonComponentState`:

- `enabled`
- `disabled`
- `loading`
- `active`
- `readonly`

Estado de interacción:

```php
use W4\UiFramework\Components\UI\Button\ButtonInteractState;

$button->interactState(new ButtonInteractState(
    hovered: true,
    focused: false,
    pressed: false
));
```

## 3. 🎨 Variantes por Tema

El `Button` no define clases CSS directamente; delega en el `ThemeResolver`.

Bootstrap (`BootstrapTheme`):

- variantes: `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, `dark`
- tamaños: `sm`, `md`, `lg`
- estado `disabled/loading/readonly` agrega atributos de deshabilitado

DaisyUI (`DaisyTheme`):

- variantes: `primary`, `secondary`, `accent`, `success`, `warning`, `info`, `error`, `danger`, `ghost`, `link`
- tamaños: `xs`, `sm`, `md`, `lg`
- estado `loading` agrega clase `loading`

## 4. 🖥️ Formas de Renderizar el Button

### 4.1 Helper global (`w4_render`)

```php
use W4\UiFramework\Components\UI\Button\Button;

echo w4_render(
    Button::make('Guardar')->primary()->lg()
);
```

### 4.2 Facade (`W4Ui`)

```php
use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Facades\W4Ui;

echo W4Ui::render(
    Button::make('Eliminar')->danger()->sm()
);
```

### 4.3 Componente Blade genérico (`x-w4-render`)

```php
@php
    $button = \W4\UiFramework\Components\UI\Button\Button::make('Enviar')->success();
@endphp

<x-w4-render :component="$button" />
```

### 4.4 Componente Blade directo (`x-w4-button`)

```blade
<x-w4-button
    label="Guardar"
    name="save"
    variant="primary"
    size="md"
    type="submit"
/>
```

Parámetros Blade más comunes en `x-w4-button`:

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

### 4.5 Vista/payload para integración avanzada

```php
use W4\UiFramework\Components\UI\Button\Button;
use W4\UiFramework\Components\UI\Button\ButtonComponentState;
use W4\UiFramework\Facades\W4Ui;

$button = Button::make('Procesar')->state(ButtonComponentState::LOADING);

$view = W4Ui::view($button);
$payload = W4Ui::payload($button);
```

`payload` devuelve la estructura normalizada (`renderer`, `view`, `data`, `theme`) útil para inspección o bridges.

### 4.6 Ejemplo de uso dentro de un controlador Laravel

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
            ->primary()
            ->lg()
            ->attribute('type', 'submit');

        return view('checkout.create', [
            'submitButtonHtml' => W4Ui::render($submitButton),
        ]);
    }
}
```

En la vista `resources/views/checkout/create.blade.php`:

```blade
<form method="POST" action="{{ route('checkout.store') }}">
    @csrf
    {!! $submitButtonHtml !!}
</form>
```

## 5. 🔧 Personalización por atributo y tema

Ejemplo con tema DaisyUI por componente:

```php
$button = Button::make('Continuar')
    ->theme('daisyui')
    ->variant('accent')
    ->attribute('class', 'w-full')
    ->attribute('type', 'submit');

echo w4_render($button);
```

## 6. 📦 Salida Blade base del paquete

La vista por defecto del botón es:

`resources/views/button.blade.php`

El renderer Blade del core apunta a:

`w4-ui::button`

Con esto, cualquier `Button` renderizado por el driver `blade` termina en esa vista usando `data` + `theme` resueltos por pipeline.
