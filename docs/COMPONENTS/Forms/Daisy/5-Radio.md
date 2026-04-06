# 🚀 W4-UI-Framework

## ✨ Contexto del componente Daisy Radio

## 1. 📌 Información General

`Daisy Radio` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\Forms\Radio\Radio`

y aplica estilos/atributos a través del resolver DaisyUI:

`W4\UiFramework\Themes\DaisyUI\Components\Forms\RadioThemeResolver`

## 2. 🧱 API base del Radio (heredada)

```php
use W4\UiFramework\Components\Forms\Radio\Radio;
use W4\UiFramework\Components\Forms\Radio\RadioComponentEvent;

$radio = Radio::make('Plan Pro')
    ->name('plan_pro')
    ->id('radio-plan-pro')
    ->theme('daisyui')
    ->value('pro')
    ->group('plan')
    ->selected(true)
    ->variant('primary')
    ->size('md')
    ->dispatch(RadioComponentEvent::SET_VALID);
```

Estados:

- `enabled`
- `disabled`
- `readonly`
- `invalid`
- `valid`
- `loading`

Eventos:

- `focus`, `blur`, `change`, `select`, `clear`
- `disable`, `enable`, `set_readonly`
- `set_invalid`, `set_valid`
- `start_loading`, `finish_loading`, `reset`

## 3. 🎨 Resolución visual DaisyUI

Base:

- `radio`

Variantes:

- `radio-neutral`, `radio-primary`, `radio-secondary`, `radio-accent`, `radio-success`, `radio-warning`, `radio-error`, `radio-info`

Tamaños:

- `xs` -> `radio-xs`
- `sm` -> `radio-sm`
- `md` -> `radio-md`
- `lg/xl` -> `radio-lg`

Estados:

- `valid` -> `radio-success`
- `invalid` -> `radio-error`
- `loading` -> `opacity-75`

Atributos:

- `type=radio`, `name`, `id`, `value`, `checked`
- `disabled`, `readonly`
- `aria-invalid`, `aria-busy`, `aria-checked`
- `data-focused`, `data-hovered`, `data-pressed`

## 4. 🖥️ Formas de renderizar Daisy Radio

### 4.1 Helper

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Radio\Radio::make('Plan Pro')
        ->theme('daisyui')
        ->group('plan')
        ->value('pro')
        ->selected(true)
        ->variant('primary')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\Forms\Radio\Radio;

echo W4Ui::render(
    Radio::make('Plan Basic')
        ->theme('daisyui')
        ->group('plan')
        ->value('basic')
        ->variant('neutral')
);
```

### 4.3 Blade

```blade
<x-w4-radio
    theme="daisyui"
    label="Plan Pro"
    group="plan"
    value="pro"
    variant="primary"
    :selected="true"
/>
```

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Radio\Radio::make('Plan Pro')
        ->theme('daisyui')
        ->group('plan')
        ->value('pro')
        ->state(\W4\UiFramework\Components\Forms\Radio\RadioComponentState::ENABLED)
);
```

Render helper con estado `invalid`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Radio\Radio::make('Plan Pro')
        ->theme('daisyui')
        ->group('plan')
        ->value('pro')
        ->state(\W4\UiFramework\Components\Forms\Radio\RadioComponentState::INVALID)
);
```

Render helper con estado `loading`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Radio\Radio::make('Plan Pro')
        ->theme('daisyui')
        ->group('plan')
        ->value('pro')
        ->state(\W4\UiFramework\Components\Forms\Radio\RadioComponentState::LOADING)
);
```

Render por evento `set_invalid`:

```php
use W4\UiFramework\Components\Forms\Radio\RadioComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\Radio\Radio::make('Plan Pro')
        ->theme('daisyui')
        ->group('plan')
        ->value('pro')
        ->dispatch(RadioComponentEvent::SET_INVALID)
);
```

Render por evento `start_loading`:

```php
use W4\UiFramework\Components\Forms\Radio\RadioComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\Radio\Radio::make('Plan Pro')
        ->theme('daisyui')
        ->group('plan')
        ->value('pro')
        ->dispatch(RadioComponentEvent::START_LOADING)
);
```

Render por evento `reset` después de invalidar:

```php
use W4\UiFramework\Components\Forms\Radio\RadioComponentEvent;

$radio = \W4\UiFramework\Components\Forms\Radio\Radio::make('Plan Pro')
    ->theme('daisyui')
    ->group('plan')
    ->value('pro')
    ->dispatch(RadioComponentEvent::SET_INVALID)
    ->dispatch(RadioComponentEvent::RESET);

echo w4_render($radio);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-radio`)

```blade
<x-w4-radio label="Inválido" theme="daisyui" group="plan" value="pro" :invalid="true" />
<x-w4-radio label="Deshabilitado" theme="daisyui" group="plan" value="pro" :disabled="true" />
<x-w4-radio label="Cargando" theme="daisyui" group="plan" value="pro" :loading="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el radio sin `:invalid`, `:loading`, `:disabled` ni `:readonly`.

## 5. 🧭 Ejemplos prácticos Daisy

```blade
<x-w4-radio label="Pro" theme="daisyui" group="plan" value="pro" :selected="true" />
<x-w4-radio label="Basic" theme="daisyui" group="plan" value="basic" />
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\Forms\Radio\Radio;
use W4\UiFramework\Facades\W4Ui;

class PlanController extends Controller
{
    public function edit(): View
    {
        $planPro = Radio::make('Plan Pro')
            ->name('plan_pro')
            ->id('radio-plan-pro')
            ->theme('daisyui')
            ->group('plan')
            ->value('pro')
            ->selected(true)
            ->variant('primary');

        return view('plan.edit', [
            'planProHtml' => W4Ui::render($planPro),
        ]);
    }
}
```

## 7. 📦 Notas de integración

- El Daisy Radio usa payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende del tema activo `daisyui` (global o por componente).
