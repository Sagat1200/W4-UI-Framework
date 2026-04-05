# 🚀 W4-UI-Framework

## ✨ Contexto del componente DaisyUI Link

## 1. 📌 Información General

`DaisyUI Link` usa:

- componente base `W4\UiFramework\Components\UI\Link\Link`
- resolver `W4\UiFramework\Themes\DaisyUI\Components\UI\LinkThemeResolver`

## 2. 🧱 API del componente

```php
use W4\UiFramework\Components\UI\Link\Link;

$link = Link::make('Repositorio')
    ->theme('daisyui')
    ->text('Ver repositorio')
    ->href('https://github.com')
    ->target('_blank')
    ->rel('noopener')
    ->variant('primary')
    ->size('md');
```

Estados:

- `enabled`
- `disabled`
- `active`
- `hidden`

Eventos:

- `activate`
- `deactivate`
- `disable`
- `enable`
- `hide`
- `show`
- `reset`

## 3. 🎨 Resolución visual DaisyUI

Base:

- `link`

Variantes:

- `link-neutral`, `link-primary`, `link-secondary`, `link-accent`, `link-success`, `link-warning`, `link-error`, `link-info`

Tamaños:

- `xs` -> `text-xs`
- `sm` -> `text-sm`
- `md` -> `text-base`
- `lg` -> `text-lg`
- `xl` -> `text-xl`

Estados:

- `disabled` -> `opacity-50 pointer-events-none`
- `active` -> `link-hover font-semibold`
- `hidden` -> `hidden`

Atributos:

- `href`
- `target`
- `rel`
- `aria-disabled`
- `tabindex`
- `aria-hidden`
- `data-state`

## 4. 🖥️ Formas de renderizar DaisyUI Link

### 4.1 Helper

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
        ->variant('primary')
        ->size('lg')
);
```

### 4.3 Blade

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

### 4.4 Estados en Blade

```blade
<x-w4-link label="Activo" theme="daisyui" href="#" :active="true" />
<x-w4-link label="Deshabilitado" theme="daisyui" href="#" :disabled="true" />
<x-w4-link label="Oculto" theme="daisyui" href="#" :hidden="true" />
```

## 5. 🧭 Auditoría con componentId

```blade
<x-w4-link
    label="Link auditado"
    theme="daisyui"
    href="https://w4.software"
    :componentId="'link-9002'"
/>
```

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Link\Link::make('Audit')
        ->theme('daisyui')
        ->href('https://w4.software')
        ->meta('component_id', 'link-9002')
        ->attribute('data-component-id', 'link-9002')
);
```
