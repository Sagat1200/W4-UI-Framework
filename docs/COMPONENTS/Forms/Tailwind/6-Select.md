# 🚀 W4-UI-Framework

## ✨ Contexto del componente Tailwind Select

## 1. 📌 Información General

`Tailwind Select` reutiliza:

`W4\UiFramework\Components\Forms\Select\Select`

y aplica estilos con:

`W4\UiFramework\Themes\Tailwind\Components\Forms\SelectThemeResolver`

## 2. 🧱 API base del Select (heredada)

```php
use W4\UiFramework\Components\Forms\Select\Select;
use W4\UiFramework\Components\Forms\Select\SelectComponentEvent;

$select = Select::make('Plan')
    ->theme('tailwind')
    ->options(['basic' => 'Basic', 'pro' => 'Pro'])
    ->selected('pro')
    ->placeholder('Selecciona un plan')
    ->variant('primary')
    ->size('md')
    ->dispatch(SelectComponentEvent::SET_VALID);
```

Estados:

- `enabled`, `disabled`, `readonly`, `invalid`, `valid`, `loading`

Eventos:

- `focus`, `blur`, `change`, `select`, `clear`
- `disable`, `enable`, `set_readonly`
- `set_invalid`, `set_valid`
- `start_loading`, `finish_loading`, `reset`

## 3. 🎨 Resolución visual Tailwind

Base:

- `block w-full rounded-md border transition ...`

Variantes:

- `border-slate-*`, `border-blue-*`, `border-violet-*`, `border-cyan-*`, `border-emerald-*`, `border-amber-*`, `border-rose-*`

Tamaños:

- `xs..xl` con `px/py/text-*`

Estados:

- `valid` -> `border-emerald-500 text-emerald-600`
- `invalid` -> `border-rose-500 text-rose-600`
- `loading` -> `opacity-75 animate-pulse`

## 4. 🖥️ Formas de renderizar Tailwind Select

### 4.1 Helper

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Select\Select::make('Plan')
        ->theme('tailwind')
        ->options(['basic' => 'Basic', 'pro' => 'Pro'])
        ->selected('pro')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\Forms\Select\Select;

echo W4Ui::render(
    Select::make('Plan')
        ->theme('tailwind')
        ->options(['basic' => 'Basic', 'pro' => 'Pro'])
);
```

### 4.3 Blade

```blade
<x-w4-select
    theme="tailwind"
    label="Plan"
    :options="['basic' => 'Basic', 'pro' => 'Pro']"
    selected="pro"
    placeholder="Selecciona un plan"
    variant="primary"
/>
```

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Select\Select::make('Plan')
        ->theme('tailwind')
        ->options(['basic' => 'Basic', 'pro' => 'Pro'])
        ->state(\W4\UiFramework\Components\Forms\Select\SelectComponentState::ENABLED)
);
```

Render helper con estado `invalid`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Select\Select::make('Plan')
        ->theme('tailwind')
        ->options(['basic' => 'Basic', 'pro' => 'Pro'])
        ->state(\W4\UiFramework\Components\Forms\Select\SelectComponentState::INVALID)
);
```

Render helper con estado `loading`:

```php
echo w4_render(
    \W4\UiFramework\Components\Forms\Select\Select::make('Plan')
        ->theme('tailwind')
        ->options(['basic' => 'Basic', 'pro' => 'Pro'])
        ->state(\W4\UiFramework\Components\Forms\Select\SelectComponentState::LOADING)
);
```

Render por evento `set_invalid`:

```php
use W4\UiFramework\Components\Forms\Select\SelectComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\Select\Select::make('Plan')
        ->theme('tailwind')
        ->options(['basic' => 'Basic', 'pro' => 'Pro'])
        ->dispatch(SelectComponentEvent::SET_INVALID)
);
```

Render por evento `start_loading`:

```php
use W4\UiFramework\Components\Forms\Select\SelectComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\Forms\Select\Select::make('Plan')
        ->theme('tailwind')
        ->options(['basic' => 'Basic', 'pro' => 'Pro'])
        ->dispatch(SelectComponentEvent::START_LOADING)
);
```

Render por evento `reset` después de invalidar:

```php
use W4\UiFramework\Components\Forms\Select\SelectComponentEvent;

$select = \W4\UiFramework\Components\Forms\Select\Select::make('Plan')
    ->theme('tailwind')
    ->options(['basic' => 'Basic', 'pro' => 'Pro'])
    ->dispatch(SelectComponentEvent::SET_INVALID)
    ->dispatch(SelectComponentEvent::RESET);

echo w4_render($select);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-select`)

```blade
<x-w4-select theme="tailwind" label="Plan" :options="['basic'=>'Basic','pro'=>'Pro']" :invalid="true" />
<x-w4-select theme="tailwind" label="Plan" :options="['basic'=>'Basic','pro'=>'Pro']" :loading="true" />
<x-w4-select theme="tailwind" label="Plan" :options="['basic'=>'Basic','pro'=>'Pro']" :disabled="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el select sin `:invalid`, `:loading`, `:disabled` ni `:readonly`.

## 5. 🧭 Ejemplos prácticos Tailwind

```blade
<x-w4-select theme="tailwind" label="Plan" :options="['basic'=>'Basic','pro'=>'Pro']" selected="pro" />
<x-w4-select theme="tailwind" label="Opciones" :options="['a'=>'A','b'=>'B']" :multiple="true" :selected="['a','b']" />
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\Forms\Select\Select;
use W4\UiFramework\Facades\W4Ui;

class PlanController extends Controller
{
    public function edit(): View
    {
        $planSelect = Select::make('Plan')
            ->theme('tailwind')
            ->options(['basic' => 'Basic', 'pro' => 'Pro'])
            ->selected('pro');

        return view('plan.edit', [
            'planSelectHtml' => W4Ui::render($planSelect),
        ]);
    }
}
```

## 7. 📦 Notas de integración

- Usa payload estándar (`renderer`, `view`, `data`, `theme`).
- Depende del tema activo `tailwind` (global o por componente).
