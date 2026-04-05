# 🚀 W4-UI-Framework

## ✨ Contexto del componente Bootstrap Link

## 1. 📌 Información General

`Bootstrap Link` en este paquete reutiliza el componente base:

`W4\UiFramework\Components\UI\Link\Link`

y aplica estilos/atributos a través del resolver Bootstrap:

`W4\UiFramework\Themes\Bootstrap\Components\UI\LinkThemeResolver`

Esto significa que la API funcional del link base se conserva, y Bootstrap define cómo se ven variantes, tamaños y estados.

## 2. 🧱 API base del Link (heredada)

Creación base:

```php
use W4\UiFramework\Components\UI\Link\Link;

$link = Link::make('Documentación');
```

Fluent API más usada:

```php
$link = Link::make('Documentación')
    ->name('docs_link')
    ->id('lnk-docs')
    ->theme('bootstrap')
    ->text('Ver documentación')
    ->href('https://w4.software')
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

## 3. 🎨 Resolución visual Bootstrap (ThemeResolver)

Según `LinkThemeResolver`, Bootstrap Link usa clase base:

- `link-offset-2`

### 3.1 Variantes Bootstrap disponibles

Mapeo actual de `variant`:

- `primary` -> `link-primary`
- `secondary` -> `link-secondary`
- `success` -> `link-success`
- `warning` -> `link-warning`
- `danger` o `error` -> `link-danger`
- `info` -> `link-info`
- `light` -> `link-light`
- `dark` -> `link-dark`
- `neutral` y valor no reconocido -> `link-body-emphasis`

### 3.2 Tamaños Bootstrap disponibles

Mapeo actual de `size`:

- `xs` -> `fs-6`
- `sm` -> `fs-5`
- `md` -> `fs-4`
- `lg` -> `fs-3`
- `xl` -> `fs-2`

### 3.3 Estados y clases adicionales

- `state=disabled` agrega `disabled opacity-50`
- `state=active` agrega `text-decoration-underline`
- `state=hidden` agrega `d-none`
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

## 4. 🖥️ Formas de renderizar Bootstrap Link

Nota de uso de tema:

- Usa `theme="bootstrap"` en `x-w4-link` cuando el tema global de tu app no sea Bootstrap y quieras forzar Bootstrap solo para ese link.
- Usa `->theme('bootstrap')` en `Link::make(...)` cuando renderizas por helper/facade/controlador y quieras forzar Bootstrap en esa instancia.
- Si tu configuración global ya está en Bootstrap, no es obligatorio repetir `theme="bootstrap"` ni `->theme('bootstrap')`.
- Mantén `theme="bootstrap"` o `->theme('bootstrap')` en snippets de documentación cuando quieras un ejemplo explícito.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Documentación')
        ->theme('bootstrap')
        ->text('Ver documentación')
        ->href('https://w4.software')
        ->variant('primary')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Link\Link;

echo W4Ui::render(
    Link::make('Sitio')
        ->theme('bootstrap')
        ->text('Ir al sitio')
        ->href('https://w4.software')
        ->target('_blank')
        ->rel('noopener')
        ->variant('info')
        ->size('lg')
);
```

### 4.3 Componente Blade directo (`x-w4-link`)

```blade
<x-w4-link
    theme="bootstrap"
    label="Sitio W4"
    text="Ir al sitio"
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
    \W4\UiFramework\Components\UI\Link\Link::make('Visible')
        ->theme('bootstrap')
        ->href('https://w4.software')
        ->state(\W4\UiFramework\Components\UI\Link\LinkComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Bloqueado')
        ->theme('bootstrap')
        ->href('https://w4.software')
        ->state(\W4\UiFramework\Components\UI\Link\LinkComponentState::DISABLED)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Activo')
        ->theme('bootstrap')
        ->href('https://w4.software')
        ->state(\W4\UiFramework\Components\UI\Link\LinkComponentState::ACTIVE)
);
```

Render por evento `activate`:

```php
use W4\UiFramework\Components\UI\Link\LinkComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\Link\Link::make('Activar link')
        ->theme('bootstrap')
        ->href('https://w4.software')
        ->dispatch(LinkComponentEvent::ACTIVATE)
);
```

Render por evento `reset`:

```php
use W4\UiFramework\Components\UI\Link\LinkComponentEvent;

$link = \W4\UiFramework\Components\UI\Link\Link::make('Reset')
    ->theme('bootstrap')
    ->href('https://w4.software')
    ->dispatch(LinkComponentEvent::ACTIVATE)
    ->dispatch(LinkComponentEvent::RESET);

echo w4_render($link);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-link`)

```blade
<x-w4-link label="Activo" theme="bootstrap" href="#" :active="true" />
<x-w4-link label="Deshabilitado" theme="bootstrap" href="#" :disabled="true" />
<x-w4-link label="Oculto" theme="bootstrap" href="#" :hidden="true" />
```

Para volver al estado base (`reset`) en Blade, renderiza el link sin `:active`, `:disabled` ni `:hidden`.

## 5. 🧭 Ejemplos prácticos Bootstrap

Link de navegación principal:

```blade
<x-w4-link
    label="Sitio W4"
    theme="bootstrap"
    href="https://w4.software"
    variant="primary"
    size="md"
/>
```

Link informativo:

```blade
<x-w4-link
    label="Documentación"
    theme="bootstrap"
    href="https://w4.software"
    variant="info"
    size="lg"
/>
```

Link con `componentId` para auditoría/estado:

```blade
<x-w4-link
    label="Link auditado"
    theme="bootstrap"
    href="https://w4.software"
    :componentId="'link-9001'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Link\Link::make('Audit')
        ->theme('bootstrap')
        ->href('https://w4.software')
        ->meta('component_id', 'link-9001')
        ->attribute('data-component-id', 'link-9001')
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
        $docsLink = Link::make('Documentación')
            ->name('docs_link')
            ->id('lnk-docs')
            ->theme('bootstrap')
            ->href('https://w4.software')
            ->target('_blank')
            ->rel('noopener')
            ->variant('primary')
            ->size('md');

        return view('docs.index', [
            'docsLinkHtml' => W4Ui::render($docsLink),
        ]);
    }
}
```

En la vista:

```blade
{!! $docsLinkHtml !!}
```

## 7. 📦 Notas de integración

- El Bootstrap Link usa payload estándar (`renderer`, `view`, `data`, `theme`).
- La resolución final depende de que el tema activo sea `bootstrap` (global o por componente).
- Si usas optimización de CSS en producción, asegúrate de incluir clases `link-*`, `fs-*`, `d-none`, `opacity-50`, `disabled` y `text-decoration-underline`.
