# 🚀 W4-UI-Framework

## ✨ Contexto del componente Bootstrap Text

## 1. 📌 Información General

`Bootstrap Text` usa:

- componente base `W4\UiFramework\Components\UI\Text\Text`
- resolver `W4\UiFramework\Themes\Bootstrap\Components\UI\TextThemeResolver`

## 2. 🧱 API del componente

```php
use W4\UiFramework\Components\UI\Text\Text;

$text = Text::make('Estado')
    ->theme('bootstrap')
    ->text('Estado del sistema')
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

- `d-inline-block`

Variantes:

- `text-primary`, `text-secondary`, `text-success`, `text-warning`, `text-danger`, `text-info`, `text-light`, `text-dark`, `text-body`

Tamaños:

- `xs` -> `fs-6`
- `sm` -> `fs-5`
- `md` -> `fs-4`
- `lg` -> `fs-3`
- `xl` -> `fs-2`

Estados:

- `disabled` -> `opacity-50`
- `active` -> `fw-semibold`
- `hidden` -> `d-none`

Atributos:

- `role="text"`
- `aria-hidden`
- `data-state`

## 4. 🖥️ Formas de renderizar Bootstrap Text

### 4.1 Helper

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Estado')
        ->theme('bootstrap')
        ->text('Estado activo')
        ->variant('success')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Text\Text;

echo W4Ui::render(
    Text::make('Resumen')
        ->theme('bootstrap')
        ->text('Operación completada')
        ->variant('primary')
        ->size('lg')
);
```

### 4.3 Blade

```blade
<x-w4-text
    theme="bootstrap"
    label="Estado"
    text="Operación completada"
    variant="primary"
    size="md"
/>
```

### 4.4 Estados en Blade

```blade
<x-w4-text label="Activo" theme="bootstrap" :active="true" />
<x-w4-text label="Deshabilitado" theme="bootstrap" :disabled="true" />
<x-w4-text label="Oculto" theme="bootstrap" :hidden="true" />
```

## 5. 🧭 Auditoría con componentId

```blade
<x-w4-text
    label="Texto auditado"
    theme="bootstrap"
    :componentId="'text-9001'"
/>
```

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Text\Text::make('Audit')
        ->theme('bootstrap')
        ->meta('component_id', 'text-9001')
        ->attribute('data-component-id', 'text-9001')
);
```
