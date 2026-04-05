# 🚀 W4-UI-Framework

## ✨ Contexto del componente Daisy Link

## 1. 📌 Información General

`Daisy Link` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\UI\Link\Link`

y aplica estilos/atributos a través del resolver DaisyUI:

`W4\UiFramework\Themes\DaisyUI\Components\UI\LinkThemeResolver`

Esto significa que la API funcional del link base se conserva, y el tema DaisyUI define cómo se ven variantes, tamaños y estados.

## 2. 🧱 API base del Link (heredada)

Creación base:

```php
use W4\UiFramework\Components\UI\Link\Link;

$link = Link::make('Repositorio');
```

Fluent API más usada:

```php
$link = Link::make('Repositorio')
    ->name('repo_link')
    ->id('lnk-repo')
    ->theme('daisyui')
    ->text('Ver repositorio')
    ->href('https://github.com')
    ->target('_blank')
    ->rel('noopener')
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

## 3. 🎨 Resolución visual DaisyUI (ThemeResolver)

Según `LinkThemeResolver`, Daisy Link usa clase base:

- `link`

### 3.1 Variantes Daisy disponibles

Mapeo actual de `variant`:

- `neutral` -> `link-neutral`
- `primary` -> `link-primary`
- `secondary` -> `link-secondary`
- `accent` -> `link-accent`
- `success` -> `link-success`
- `warning` -> `link-warning`
- `error` o `danger` -> `link-error`
- `info` -> `link-info`
- valor no reconocido -> `link-neutral`

### 3.2 Tamaños Daisy disponibles

Mapeo actual de `size`:

- `xs` -> `text-xs`
- `sm` -> `text-sm`
- `md` -> `text-base`
- `lg` -> `text-lg`
- `xl` -> `text-xl`

### 3.3 Estados y clases adicionales

- `state=disabled` agrega `opacity-50 pointer-events-none`
- `state=active` agrega `link-hover font-semibold`
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

## 4. 🖥️ Formas de renderizar Daisy Link

Nota de uso de tema:

- Usa `theme="daisyui"` en `x-w4-link` cuando el tema global de tu app no sea DaisyUI y quieras forzar Daisy solo para ese link.
- Usa `->theme('daisyui')` en `Link::make(...)` cuando renderizas por helper/facade/controlador y quieras forzar Daisy en esa instancia.
- Si tu configuración global ya está en DaisyUI, no es obligatorio repetir `theme="daisyui"` ni `->theme('daisyui')`.
- Mantén `theme="daisyui"` o `->theme('daisyui')` en snippets de documentación cuando quieras un ejemplo explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Repositorio')
        ->theme('daisyui')
        ->text('Ver repositorio')
        ->href('https://github.com')
        ->variant('secondary')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Link\Link;

echo W4Ui::render(
    Link::make('Sitio')
        ->theme('daisyui')
        ->text('Ir al sitio')
        ->href('https://w4.software')
        ->target('_blank')
        ->rel('noopener')
        ->variant('primary')
        ->size('lg')
);
```

### 4.3 Componente Blade directo (`x-w4-link`)

```blade
<x-w4-link
    theme="daisyui"
    label="Ir al sitio"
    href="https://w4.software"
    target="_blank"
    rel="noopener"
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
    \W4\UiFramework\Components\UI\Link\Link::make('Repositorio visible')
        ->theme('daisyui')
        ->href('https://github.com')
        ->state(\W4\UiFramework\Components\UI\Link\LinkComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Repositorio bloqueado')
        ->theme('daisyui')
        ->href('https://github.com')
        ->state(\W4\UiFramework\Components\UI\Link\LinkComponentState::DISABLED)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Repositorio activo')
        ->theme('daisyui')
        ->href('https://github.com')
        ->state(\W4\UiFramework\Components\UI\Link\LinkComponentState::ACTIVE)
);
```

Render por evento `activate`:

```php
use W4\UiFramework\Components\UI\Link\LinkComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Activar link')
        ->theme('daisyui')
        ->href('https://github.com')
        ->dispatch(LinkComponentEvent::ACTIVATE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\UI\Link\LinkComponentEvent;

$link = \W4\UiFramework\Components\UI\Link\Link::make('Reset')
    ->theme('daisyui')
    ->href('https://github.com')
    ->dispatch(LinkComponentEvent::ACTIVATE)
    ->dispatch(LinkComponentEvent::RESET);

echo w4_render($link);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-link`)

```blade
<x-w4-link label="Activo" theme="daisyui" href="#" :active="true" />
<x-w4-link label="Deshabilitado" theme="daisyui" href="#" :disabled="true" />
<x-w4-link label="Oculto" theme="daisyui" href="#" :hidden="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el link sin `:active`, `:disabled` ni `:hidden`.

## 5. 🧭 Ejemplos prácticos Daisy

Link de navegación principal:

```blade
<x-w4-link
    label="Ir al panel"
    theme="daisyui"
    href="/dashboard"
    variant="primary"
    size="md"
/>
```

Link externo:

```blade
<x-w4-link
    label="Ver repositorio"
    theme="daisyui"
    href="https://github.com"
    target="_blank"
    rel="noopener"
    variant="secondary"
/>
```

Link con `componentId` para auditoría/estado:

```blade
<x-w4-link
    label="Link auditado"
    theme="daisyui"
    href="https://w4.software"
    :componentId="'link-9002'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Link\Link::make('Audit')
        ->theme('daisyui')
        ->href('https://w4.software')
        ->meta('component_id', 'link-9002')
        ->attribute('data-component-id', 'link-9002')
);
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use W4\UiFramework\Components\UI\Link\Link;
use W4\UiFramework\Facades\W4Ui;

class DocsController extends Controller
{
    public function index(): View
    {
        $repoLink = Link::make('Repositorio')
            ->name('repo_link')
            ->id('lnk-repo')
            ->theme('daisyui')
            ->href('https://github.com')
            ->target('_blank')
            ->rel('noopener')
            ->variant('primary')
            ->size('md');

        return view('docs.index', [
            'repoLinkHtml' => W4Ui::render($repoLink),
        ]);
    }
}
```

En la vista:

```blade
{!! $repoLinkHtml !!}
```

## 7. 📦 Notas de integración

- El Daisy Link usa payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `daisyui` (global o por componente).
- Si usas purge en Tailwind/DaisyUI, asegúrate de incluir clases `link-*`, `text-*`, `hidden`, `opacity-50`, `pointer-events-none` y `link-hover`.
