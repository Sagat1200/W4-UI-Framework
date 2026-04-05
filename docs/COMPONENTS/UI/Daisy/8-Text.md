# 🚀 W4-UI-Framework

## ✨ Contexto del componente DaisyUI Text

## 1. 📌 Información General

`DaisyUI Text` usa:

- componente base `W4\UiFramework\Components\UI\Text\Text`
- resolver `W4\UiFramework\Themes\DaisyUI\Components\UI\TextThemeResolver`

## 2. 🧱 API del componente

```php
use W4\UiFramework\Components\UI\Text\Text;

$text = Text::make('Estado')
    ->theme('daisyui')
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

## 3. 🎨 Resolución visual DaisyUI

Base:

- `inline-block`

Variantes:

- `text-base-content`, `text-primary`, `text-secondary`, `text-accent`, `text-success`, `text-warning`, `text-error`, `text-info`

Tamaños:

- `xs` -> `text-xs`
- `sm` -> `text-sm`
- `md` -> `text-base`
- `lg` -> `text-lg`
- `xl` -> `text-xl`

Estados:

- `disabled` -> `opacity-50`
- `active` -> `font-semibold`
- `hidden` -> `hidden`

Atributos:

- `role="text"`
- `aria-hidden`
- `data-state`

## 4. 🖥️ Formas de renderizar DaisyUI Text

### 4.1 Helper

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Estado')
        ->theme('daisyui')
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
        ->theme('daisyui')
        ->text('Operación completada')
        ->variant('primary')
        ->size('lg')
);
```

### 4.3 Blade

```blade
<x-w4-text
    theme="daisyui"
    label="Estado"
    text="Operación completada"
    variant="primary"
    size="md"
/>
```

### 4.4 Estados en Blade

```blade
<x-w4-text label="Activo" theme="daisyui" :active="true" />
<x-w4-text label="Deshabilitado" theme="daisyui" :disabled="true" />
<x-w4-text label="Oculto" theme="daisyui" :hidden="true" />
```

## 5. 🧭 Auditoría con componentId

```blade
<x-w4-text
    label="Texto auditado"
    theme="daisyui"
    :componentId="'text-9002'"
/>
```

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Text\Text::make('Audit')
        ->theme('daisyui')
        ->meta('component_id', 'text-9002')
        ->attribute('data-component-id', 'text-9002')
);
```
