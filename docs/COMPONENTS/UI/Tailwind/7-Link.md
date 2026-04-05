# 🚀 W4-UI-Framework

## ✨ Contexto del componente Tailwind Link

## 1. 📌 Información General

`Tailwind Link` usa:

- componente base `W4\UiFramework\Components\UI\Link\Link`
- resolver `W4\UiFramework\Themes\Tailwind\Components\UI\LinkThemeResolver`

## 2. 🧱 API del componente

```php
use W4\UiFramework\Components\UI\Link\Link;

$link = Link::make('Ayuda')
    ->theme('tailwind')
    ->text('Centro de ayuda')
    ->href('/help')
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

## 3. 🎨 Resolución visual Tailwind

Base:

- `inline-flex items-center underline underline-offset-4 transition`

Variantes:

- `text-blue-*`, `text-slate-*`, `text-violet-*`, `text-emerald-*`, `text-amber-*`, `text-rose-*`, `text-cyan-*`

Tamaños:

- `xs` -> `text-xs`
- `sm` -> `text-sm`
- `md` -> `text-base`
- `lg` -> `text-lg`
- `xl` -> `text-xl`

Estados:

- `disabled` -> `opacity-50 pointer-events-none`
- `active` -> `font-semibold`
- `hidden` -> `hidden`

Atributos:

- `href`
- `target`
- `rel`
- `aria-disabled`
- `tabindex`
- `aria-hidden`
- `data-state`

## 4. 🖥️ Formas de renderizar Tailwind Link

### 4.1 Helper

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

### 4.3 Blade

```blade
<x-w4-link
    theme="tailwind"
    label="Centro de ayuda"
    href="/help"
    variant="primary"
    size="md"
/>
```

### 4.4 Estados en Blade

```blade
<x-w4-link label="Activo" theme="tailwind" href="/help" :active="true" />
<x-w4-link label="Deshabilitado" theme="tailwind" href="/help" :disabled="true" />
<x-w4-link label="Oculto" theme="tailwind" href="/help" :hidden="true" />
```

## 5. 🧭 Auditoría con componentId

```blade
<x-w4-link
    label="Link auditado"
    theme="tailwind"
    href="/help"
    :componentId="'link-9003'"
/>
```

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Link\Link::make('Audit')
        ->theme('tailwind')
        ->href('/help')
        ->meta('component_id', 'link-9003')
        ->attribute('data-component-id', 'link-9003')
);
```
