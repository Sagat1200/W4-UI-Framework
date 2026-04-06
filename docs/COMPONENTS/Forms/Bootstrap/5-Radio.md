# 🚀 W4-UI-Framework

## ✨ Contexto del componente Bootstrap Radio

## 1. 📌 Información General

`Bootstrap Radio` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\Forms\Radio\Radio`

y aplica estilos/atributos a través del resolver Bootstrap:

`W4\UiFramework\Themes\Bootstrap\Components\Forms\RadioThemeResolver`

## 2. 🧱 API base del Radio (heredada)

```php
use W4\UiFramework\Components\Forms\Radio\Radio;
use W4\UiFramework\Components\Forms\Radio\RadioComponentEvent;

$radio = Radio::make('Plan Pro')
    ->name('plan_pro')
    ->id('radio-plan-pro')
    ->theme('bootstrap')
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

## 3. 🎨 Resolución visual Bootstrap

Base:

- `form-check-input`

Variantes:

- `success` -> `is-valid`
- `danger/error` -> `is-invalid`
- `warning` -> `border-warning`

Tamaños:

- `sm` -> `form-check-input-sm`
- `md` -> sin clase adicional
- `lg` -> `form-check-input-lg`

Estados:

- `valid` -> `is-valid`
- `invalid` -> `is-invalid`
- `loading` -> `opacity-75`

Atributos:

- `type=radio`, `name`, `id`, `value`, `checked`
- `disabled`, `readonly`
- `aria-invalid`, `aria-busy`, `aria-checked`
- `data-focused`, `data-hovered`, `data-pressed`

## 4. 🖥️ Formas de renderizar Bootstrap Radio

### 4.1 Helper

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Radio\Radio::make('Plan Pro')
        ->theme('bootstrap')
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
        ->theme('bootstrap')
        ->group('plan')
        ->value('basic')
        ->variant('neutral')
);
```

### 4.3 Blade

```blade
<x-w4-radio
    theme="bootstrap"
    label="Plan Pro"
    group="plan"
    value="pro"
    variant="primary"
    :selected="true"
/>
```

### 4.4 Estados en Blade

```blade
<x-w4-radio label="Inválido" theme="bootstrap" group="plan" value="pro" :invalid="true" />
<x-w4-radio label="Deshabilitado" theme="bootstrap" group="plan" value="pro" :disabled="true" />
```

## 5. 🧭 Ejemplos prácticos Bootstrap

```blade
<x-w4-radio label="Pro" theme="bootstrap" group="plan" value="pro" :selected="true" />
<x-w4-radio label="Basic" theme="bootstrap" group="plan" value="basic" />
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
            ->theme('bootstrap')
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

- El Bootstrap Radio usa payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende del tema activo `bootstrap` (global o por componente).
