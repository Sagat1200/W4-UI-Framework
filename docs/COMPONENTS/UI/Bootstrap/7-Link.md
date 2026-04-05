# 🚀 W4-UI-Framework

## ✨ Contexto del componente Bootstrap Link

## 1. 📌 Información General

`Bootstrap Link` usa:

- componente base `W4\UiFramework\Components\UI\Link\Link`
- resolver `W4\UiFramework\Themes\Bootstrap\Components\UI\LinkThemeResolver`

## 2. 🧱 API del componente

```php
use W4\UiFramework\Components\UI\Link\Link;

$link = Link::make('Documentación')
    ->theme('bootstrap')
    ->text('Ver documentación')
    ->href('https://w4.software')
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

## 3. 🎨 Resolución visual Bootstrap

Base:

- `link-offset-2`

Variantes:

- `link-primary`, `link-secondary`, `link-success`, `link-warning`, `link-danger`, `link-info`, `link-light`, `link-dark`, `link-body-emphasis`

Tamaños:

- `xs` -> `fs-6`
- `sm` -> `fs-5`
- `md` -> `fs-4`
- `lg` -> `fs-3`
- `xl` -> `fs-2`

Estados:

- `disabled` -> `disabled opacity-50`
- `active` -> `text-decoration-underline`
- `hidden` -> `d-none`

Atributos:

- `href`
- `target`
- `rel`
- `aria-disabled`
- `tabindex`
- `aria-hidden`
- `data-state`

## 4. 🖥️ Formas de renderizar Bootstrap Link

### 4.1 Helper

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

### 4.3 Blade

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

### 4.4 Estados en Blade

```blade
<x-w4-link label="Activo" theme="bootstrap" href="#" :active="true" />
<x-w4-link label="Deshabilitado" theme="bootstrap" href="#" :disabled="true" />
<x-w4-link label="Oculto" theme="bootstrap" href="#" :hidden="true" />
```

## 5. 🧭 Auditoría con componentId

```blade
<x-w4-link
    label="Link auditado"
    theme="bootstrap"
    href="https://w4.software"
    :componentId="'link-9001'"
/>
```

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Link\Link::make('Audit')
        ->theme('bootstrap')
        ->href('https://w4.software')
        ->meta('component_id', 'link-9001')
        ->attribute('data-component-id', 'link-9001')
);
```
