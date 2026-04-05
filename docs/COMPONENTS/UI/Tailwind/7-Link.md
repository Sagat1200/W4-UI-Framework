# 🚀 W4-UI-Framework

## ✨ Contexto del componente Tailwind Link

## 1. 📌 Información General

`Tailwind Link` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\UI\Link\Link`

y aplica estilos/atributos a través del resolver Tailwind:

`W4\UiFramework\Themes\Tailwind\Components\UI\LinkThemeResolver`

Esto significa que la API funcional del link base se conserva, y el tema Tailwind define cómo se ven variantes, tamaños y estados.

## 2. 🧱 API base del Link (heredada)

Creación base:

```php
use W4\UiFramework\Components\UI\Link\Link;

$link = Link::make('Ayuda');
```

Fluent API más usada:

```php
$link = Link::make('Ayuda')
    ->name('help_link')
    ->id('lnk-help')
    ->theme('tailwind')
    ->text('Centro de ayuda')
    ->href('/help')
    ->variant('primary')
    ->size('md');
```

Estados funcionales soportados:

- `enabled`
- `disabled`
- `active`
- `hidden`

Eventos soportados por la state machine del link:

- `activate`
- `deactivate`
- `disable`
- `enable`
- `hide`
- `show`
- `reset`

## 3. 🎨 Resolución visual Tailwind (ThemeResolver)

Según `LinkThemeResolver`, Tailwind Link usa clases base:

- `inline-flex`
- `items-center`
- `underline`
- `underline-offset-4`
- `transition`

### 3.1 Variantes Tailwind disponibles

Mapeo actual de `variant`:

- `neutral` -> `text-slate-900 hover:text-slate-700`
- `primary` -> `text-blue-600 hover:text-blue-700`
- `secondary` -> `text-slate-700 hover:text-slate-800`
- `accent` -> `text-violet-600 hover:text-violet-700`
- `success` -> `text-emerald-600 hover:text-emerald-700`
- `warning` -> `text-amber-600 hover:text-amber-700`
- `error` o `danger` -> `text-rose-600 hover:text-rose-700`
- `info` -> `text-cyan-600 hover:text-cyan-700`
- valor no reconocido -> `text-slate-900 hover:text-slate-700`

### 3.2 Tamaños Tailwind disponibles

Mapeo actual de `size`:

- `xs` -> `text-xs`
- `sm` -> `text-sm`
- `md` -> `text-base`
- `lg` -> `text-lg`
- `xl` -> `text-xl`

### 3.3 Estados y clases adicionales

- `state=disabled` agrega `opacity-50 pointer-events-none`
- `state=active` agrega `font-semibold`
- `state=hidden` agrega `hidden`
- si el usuario pasa `class` en atributos, se hace merge con las clases resueltas

### 3.4 Atributos HTML resueltos

El resolver/flujo final de render también contempla atributos:

- `href`: usa el del usuario o el valor del componente
- `target`: usa el del usuario o el valor del componente
- `rel`: usa el del usuario o el valor del componente
- `aria-disabled`: `'true'` cuando el estado es `disabled`
- `tabindex`: `-1` cuando el estado es `disabled`
- `aria-hidden`: `'true'` cuando el estado es `hidden`
- `data-state`: estado final del componente

## 4. 🖥️ Formas de renderizar Tailwind Link

Nota de uso de tema:

- Usa `theme="tailwind"` en `x-w4-link` cuando el tema global de tu app no sea Tailwind y quieras forzar Tailwind solo para ese link.
- Usa `->theme('tailwind')` en `Link::make(...)` cuando renderizas por helper/facade/controlador y quieras forzar Tailwind en esa instancia.
- Si tu configuración global ya está en Tailwind, no es obligatorio repetir `theme="tailwind"` ni `->theme('tailwind')`.
- Mantén `theme="tailwind"` o `->theme('tailwind')` en snippets de documentación cuando quieras un ejemplo explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Centro de ayuda')
        ->theme('tailwind')
        ->href('/help')
        ->variant('primary')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Link\Link;

echo W4Ui::render(
    Link::make('Políticas')
        ->theme('tailwind')
        ->text('Ver políticas')
        ->href('/policies')
        ->variant('info')
        ->size('sm')
);
```

### 4.3 Componente Blade directo (`x-w4-link`)

```blade
<x-w4-link
    theme="tailwind"
    label="Centro de ayuda"
    href="/help"
    variant="primary"
    size="md"
/>
```

Parámetros Blade comunes:

- `label`
- `text`
- `id`
- `name`
- `theme`
- `renderer`
- `variant`
- `size`
- `href`
- `target`
- `rel`
- `disabled`
- `active`
- `hidden`
- `class`

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Visible')
        ->theme('tailwind')
        ->href('/help')
        ->state(\W4\UiFramework\Components\UI\Link\LinkComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Bloqueado')
        ->theme('tailwind')
        ->href('/help')
        ->state(\W4\UiFramework\Components\UI\Link\LinkComponentState::DISABLED)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Activo')
        ->theme('tailwind')
        ->href('/help')
        ->state(\W4\UiFramework\Components\UI\Link\LinkComponentState::ACTIVE)
);
```

Render por evento `activate`:

```php
use W4\UiFramework\Components\UI\Link\LinkComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Activar link')
        ->theme('tailwind')
        ->href('/help')
        ->dispatch(LinkComponentEvent::ACTIVATE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\UI\Link\LinkComponentEvent;

$link = \W4\UiFramework\Components\UI\Link\Link::make('Reset')
    ->theme('tailwind')
    ->href('/help')
    ->dispatch(LinkComponentEvent::ACTIVATE)
    ->dispatch(LinkComponentEvent::RESET);

echo w4_render($link);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-link`)

```blade
<x-w4-link label="Activo" theme="tailwind" href="/help" :active="true" />
<x-w4-link label="Deshabilitado" theme="tailwind" href="/help" :disabled="true" />
<x-w4-link label="Oculto" theme="tailwind" href="/help" :hidden="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el link sin `:active`, `:disabled` ni `:hidden`.

## 5. 🧭 Ejemplos prácticos Tailwind

Link de navegación principal:

```blade
<x-w4-link
    label="Centro de ayuda"
    theme="tailwind"
    href="/help"
    variant="primary"
    size="md"
/>
```

Link informativo:

```blade
<x-w4-link
    label="Ver políticas"
    theme="tailwind"
    href="/policies"
    variant="info"
    size="sm"
/>
```

Link con `componentId` para auditoría/estado:

```blade
<x-w4-link
    label="Link auditado"
    theme="tailwind"
    href="/help"
    :componentId="'link-9003'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Link\Link::make('Audit')
        ->theme('tailwind')
        ->href('/help')
        ->meta('component_id', 'link-9003')
        ->attribute('data-component-id', 'link-9003')
);
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\UI\Link\Link;
use W4\UiFramework\Facades\W4Ui;

class HelpController extends Controller
{
    public function index(): View
    {
        $helpLink = Link::make('Centro de ayuda')
            ->name('help_link')
            ->id('lnk-help')
            ->theme('tailwind')
            ->href('/help')
            ->variant('primary')
            ->size('md');

        return view('help.index', [
            'helpLinkHtml' => W4Ui::render($helpLink),
        ]);
    }
}
```

En la vista:

```blade
{!! $helpLinkHtml !!}
```

## 7. 📦 Notas de integración

- El Tailwind Link usa payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `tailwind` (global o por componente).
- Si usas purge en Tailwind, asegúrate de incluir clases `text-*`, `hover:text-*`, `underline`, `hidden`, `opacity-50` y `pointer-events-none`.
