# 🚀 W4-UI-Framework

## ✨ Contexto del componente Tailwind Text

## 1. 📌 Información General

`Tailwind Text` usa:

- componente base `W4\UiFramework\Components\UI\Text\Text`
- resolver `W4\UiFramework\Themes\Tailwind\Components\UI\TextThemeResolver`

## 2. 🧱 API del componente

```php
use W4\UiFramework\Components\UI\Text\Text;

$text = Text::make('Estado')
    ->theme('tailwind')
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

## 3. 🎨 Resolución visual Tailwind

Base:

- `inline-block leading-snug`

Variantes:

- `text-slate-900`, `text-blue-600`, `text-slate-700`, `text-violet-600`, `text-emerald-600`, `text-amber-600`, `text-rose-600`, `text-cyan-600`

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

## 4. 🖥️ Formas de renderizar Tailwind Text

### 4.1 Helper

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Text\Text::make('Estado')
        ->theme('tailwind')
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
        ->theme('tailwind')
        ->text('Operación completada')
        ->variant('primary')
        ->size('lg')
);
```

### 4.3 Blade

```blade
<x-w4-text
    theme="tailwind"
    label="Estado"
    text="Operación completada"
    variant="primary"
    size="md"
/>
```

### 4.4 Estados en Blade

```blade
<x-w4-text label="Activo" theme="tailwind" :active="true" />
<x-w4-text label="Deshabilitado" theme="tailwind" :disabled="true" />
<x-w4-text label="Oculto" theme="tailwind" :hidden="true" />
```

## 5. 🧭 Auditoría con componentId

```blade
<x-w4-text
    label="Texto auditado"
    theme="tailwind"
    :componentId="'text-9003'"
/>
```

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Text\Text::make('Audit')
        ->theme('tailwind')
        ->meta('component_id', 'text-9003')
        ->attribute('data-component-id', 'text-9003')
);
```
