# 🚀 W4-UI-Framework

## ✨ Contexto del componente Bootstrap Divider

## 1. 📌 Información General

`Bootstrap Divider` usa:

- componente base `W4\UiFramework\Components\UI\Divider\Divider`
- resolver `W4\UiFramework\Themes\Bootstrap\Components\UI\DividerThemeResolver`

## 2. 🧱 API del componente

```php
use W4\UiFramework\Components\UI\Divider\Divider;

$divider = Divider::make()
    ->theme('bootstrap')
    ->text('Sección')
    ->variant('primary')
    ->size('md')
    ->orientation('horizontal');
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

- `d-flex align-items-center text-muted`
- horizontal: `w-100 border-top`
- vertical: `h-100 border-start`

Variantes (`border-*`):

- `primary`, `secondary`, `success`, `warning`, `danger|error`, `info`, `light`, `dark|neutral`

Tamaños:

- `xs|sm` -> `border-1`
- `md` -> `border-2`
- `lg` -> `border-3`
- `xl` -> `border-4`

Estados:

- `disabled` -> `opacity-50`
- `active` -> `border-opacity-100`
- `hidden` -> `d-none`

Atributos:

- `role="separator"`
- `aria-orientation`
- `aria-hidden`
- `data-state`

## 4. 🖥️ Formas de renderizar Bootstrap Divider

Nota de uso de tema:

- Usa `theme="bootstrap"` en `x-w4-divider` cuando el tema global no sea Bootstrap.
- Usa `->theme('bootstrap')` por helper/facade para forzar Bootstrap en esa instancia.

### 4.1 Helper

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Divider\Divider::make()
        ->theme('bootstrap')
        ->text('Detalle')
        ->variant('info')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Divider\Divider;

echo W4Ui::render(
    Divider::make()
        ->theme('bootstrap')
        ->text('Información')
        ->variant('secondary')
        ->size('lg')
);
```

### 4.3 Blade

```blade
<x-w4-divider
    theme="bootstrap"
    text="Información"
    variant="primary"
    size="md"
    orientation="horizontal"
    class="my-3"
/>
```

### 4.4 Equivalencias de render (helper vs facade vs blade)

Helper:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Divider\Divider::make()
        ->theme('bootstrap')
        ->text('Equivalente')
        ->variant('secondary')
        ->size('md')
        ->orientation('horizontal')
);
```

Facade:

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\Divider\Divider;

echo W4Ui::render(
    Divider::make()
        ->theme('bootstrap')
        ->text('Equivalente')
        ->variant('secondary')
        ->size('md')
        ->orientation('horizontal')
);
```

Blade:

```blade
<x-w4-divider
    theme="bootstrap"
    text="Equivalente"
    variant="secondary"
    size="md"
    orientation="horizontal"
/>
```

### 4.5 Ejemplos de `class` para orientación vertical (`h-*`, `w-*`)

Vertical con alto personalizado:

```blade
<x-w4-divider
    theme="bootstrap"
    text="Sección"
    orientation="vertical"
    class="h-100 my-3"
/>
```

Vertical con ancho personalizado:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\Divider\Divider::make()
        ->theme('bootstrap')
        ->text('Separador')
        ->orientation('vertical')
        ->attribute('class', 'w-25 h-100')
);
```

### 4.6 Ejemplos de renderizado por estado y evento

```php
use W4\UiFramework\Components\UI\Divider\Divider;
use W4\UiFramework\Components\UI\Divider\DividerComponentEvent;

echo w4_render(
    Divider::make()
        ->theme('bootstrap')
        ->text('Activo')
        ->dispatch(DividerComponentEvent::ACTIVATE)
);
```

```php
echo w4_render(
    Divider::make()
        ->theme('bootstrap')
        ->text('Oculto')
        ->dispatch(DividerComponentEvent::HIDE)
);
```

### 4.7 Ejemplos equivalentes en Blade (`x-w4-divider`)

```blade
<x-w4-divider text="Visible" theme="bootstrap" />
<x-w4-divider text="Activo" theme="bootstrap" :active="true" />
<x-w4-divider text="Oculto" theme="bootstrap" :hidden="true" />
```

## 5. 🧭 Ejemplos prácticos Bootstrap

Divider con `componentId` para auditoría/estado:

```blade
<x-w4-divider
    text="Separador auditado"
    theme="bootstrap"
    :componentId="'divider-9001'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\Divider\Divider::make()
        ->theme('bootstrap')
        ->meta('component_id', 'divider-9001')
        ->attribute('data-component-id', 'divider-9001')
);
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
use W4\UiFramework\Components\UI\Divider\Divider;
use W4\UiFramework\Facades\W4Ui;

public function edit()
{
    $divider = Divider::make()
        ->name('profile_divider')
        ->id('div-profile')
        ->theme('bootstrap')
        ->text('Perfil')
        ->variant('info');

    return view('profile.edit', [
        'dividerHtml' => W4Ui::render($divider),
    ]);
}
```

## 7. 📦 Notas de integración

- El Divider usa payload estándar (`renderer`, `view`, `data`, `theme`).
- `class` se mergea con clases del resolver.
- Con `W4_UI_LOG=true`, registra en `storage/logs/w4.ui.log` si tiene `componentId`.
