# 🚀 W4-UI-Framework

## ✨ Contexto del componente Daisy IconButton

## 1. 📌 Información General

`Daisy IconButton` reutiliza el componente base:

`W4\UiFramework\Components\UI\IconButton\IconButton`

y aplica estilos/atributos mediante:

`W4\UiFramework\Themes\DaisyUI\Components\UI\IconButtonThemeResolver`

El componente está pensado para acciones compactas con icono (`btn-square`) y conserva la API funcional del `IconButton` base.

## 2. 🧱 API base del IconButton (heredada)

Creación base:

```php
use W4\UiFramework\Components\UI\IconButton\IconButton;

$iconButton = IconButton::make('Actualizar');
```

Fluent API más usada:

```php
$iconButton = IconButton::make('Actualizar')
    ->id('btn-refresh')
    ->name('refresh')
    ->theme('daisyui')
    ->icon('heroicon-o-arrow-path')
    ->variant('primary')
    ->size('md')
    ->attribute('type', 'button');
```

Estados funcionales soportados:

- `enabled`
- `disabled`
- `loading`
- `readonly`
- `active`

Eventos soportados por la state machine:

- `click`
- `disable`
- `enable`
- `start_loading`
- `finish_loading`
- `set_readonly`
- `set_active`
- `reset`

## 3. 🎨 Resolución visual DaisyUI (ThemeResolver)

Según `IconButtonThemeResolver`, Daisy IconButton usa clases base:

- `btn btn-square`

### 3.1 Variantes disponibles

- `neutral` -> `btn-neutral`
- `primary` -> `btn-primary`
- `secondary` -> `btn-secondary`
- `accent` -> `btn-accent`
- `info` -> `btn-info`
- `success` -> `btn-success`
- `warning` -> `btn-warning`
- `error` -> `btn-error`
- default -> `btn-neutral`

### 3.2 Tamaños disponibles

- `xs` -> `btn-xs`
- `sm` -> `btn-sm`
- `md` -> `btn-md`
- `lg` -> `btn-lg`
- `xl` -> `btn-xl`

### 3.3 Estados y clases adicionales

- `state=loading` agrega `loading`
- `state=active` agrega `btn-active`
- `class` del usuario se mergea con clases resueltas
- si `class` incluye `h-*`, `min-h-*` o `max-h-*`, se remueven clases de tamaño Daisy para priorizar altura custom

Ejemplo de `class` con prioridad de alto:

```blade
<x-w4-icon-button
    label="Actualizar"
    icon="heroicon-o-arrow-path"
    theme="daisyui"
    variant="primary"
    size="sm"
    class="w-14 h-14"
/>
```

### 3.4 Atributos HTML resueltos

- `type`: valor de usuario o `button` por defecto
- `disabled`: `true` cuando estado es `disabled`, `loading` o `readonly`
- `aria-disabled`: `'true'` en `disabled`, `loading` o `readonly`
- `aria-pressed`: `'true'` cuando estado es `active`
- `aria-label`: toma `aria-label` del usuario o `label` del componente
- `title`: toma `title` del usuario o `label` del componente

## 4. 🖥️ Formas de renderizar Daisy IconButton

Nota de uso de tema:

- Usa `theme="daisyui"` en `x-w4-icon-button` cuando el tema global de tu proyecto no sea DaisyUI y quieras forzar Daisy solo para ese botón.
- Usa `->theme('daisyui')` en `IconButton::make(...)` cuando renderizas por helper/facade/controlador y quieres forzar Daisy en esa instancia.
- Si tu configuración global ya está en DaisyUI (`W4_UI_THEME=daisyui`), no es obligatorio repetir `theme="daisyui"` ni `->theme('daisyui')`.
- Mantén `theme="daisyui"` o `->theme('daisyui')` en ejemplos de documentación cuando quieras que el snippet sea explícito y no dependa de la configuración global.

### 4.1 Helper global

```php
echo w4_render(
    \W4\UiFramework\Components\UI\IconButton\IconButton::make('Actualizar')
        ->theme('daisyui')
        ->icon('heroicon-o-arrow-path')
        ->variant('primary')
        ->size('md')
);
```

### 4.2 Facade

```php
use W4\UiFramework\Facades\W4Ui;
use W4\UiFramework\Components\UI\IconButton\IconButton;

echo W4Ui::render(
    IconButton::make('Editar')
        ->theme('daisyui')
        ->icon('heroicon-o-pencil-square')
        ->variant('secondary')
        ->size('sm')
);
```

### 4.3 Componente Blade directo (`x-w4-icon-button`)

```blade
<x-w4-icon-button
    label="Actualizar"
    icon="heroicon-o-arrow-path"
    theme="daisyui"
    variant="primary"
    size="md"
/>
```

Parámetros Blade comunes:

- `label`
- `icon`
- `id`
- `name`
- `theme`
- `renderer`
- `variant`
- `size`
- `type`
- `disabled`
- `loading`
- `readonly`
- `active`
- `focused`
- `hovered`
- `pressed`
- `componentId`
- `class`

### 4.4 Ejemplos de renderizado por estado y evento

Render helper con estado `enabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\IconButton\IconButton::make('Actualizar')
        ->theme('daisyui')
        ->icon('heroicon-o-arrow-path')
        ->variant('primary')
        ->state(\W4\UiFramework\Components\UI\IconButton\IconButtonComponentState::ENABLED)
);
```

Render helper con estado `disabled`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\IconButton\IconButton::make('No disponible')
        ->theme('daisyui')
        ->icon('heroicon-o-lock-closed')
        ->variant('neutral')
        ->state(\W4\UiFramework\Components\UI\IconButton\IconButtonComponentState::DISABLED)
);
```

Render helper con estado `loading`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\IconButton\IconButton::make('Procesando')
        ->theme('daisyui')
        ->icon('heroicon-o-arrow-path')
        ->variant('info')
        ->state(\W4\UiFramework\Components\UI\IconButton\IconButtonComponentState::LOADING)
);
```

Render helper con estado `active`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\IconButton\IconButton::make('Seleccionado')
        ->theme('daisyui')
        ->icon('heroicon-o-star')
        ->variant('accent')
        ->state(\W4\UiFramework\Components\UI\IconButton\IconButtonComponentState::ACTIVE)
);
```

Render helper con estado `readonly`:

```php
echo w4_render(
    \W4\UiFramework\Components\UI\IconButton\IconButton::make('Solo lectura')
        ->theme('daisyui')
        ->icon('heroicon-o-eye')
        ->variant('warning')
        ->state(\W4\UiFramework\Components\UI\IconButton\IconButtonComponentState::READONLY)
);
```

Render por evento `set_active`:

```php
use W4\UiFramework\Components\UI\IconButton\IconButtonComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\IconButton\IconButton::make('Favorito')
        ->theme('daisyui')
        ->icon('heroicon-o-star')
        ->variant('success')
        ->dispatch(IconButtonComponentEvent::SET_ACTIVE)
);
```

Render por evento `start_loading`:

```php
use W4\UiFramework\Components\UI\IconButton\IconButtonComponentEvent;

echo w4_render(
    \W4\UiFramework\Components\UI\IconButton\IconButton::make('Cargando')
        ->theme('daisyui')
        ->icon('heroicon-o-arrow-path')
        ->variant('info')
        ->dispatch(IconButtonComponentEvent::START_LOADING)
);
```

Render por evento `reset` después de activar:

```php
use W4\UiFramework\Components\UI\IconButton\IconButtonComponentEvent;

$iconButton = \W4\UiFramework\Components\UI\IconButton\IconButton::make('Reset')
    ->theme('daisyui')
    ->icon('heroicon-o-arrow-path')
    ->dispatch(IconButtonComponentEvent::SET_ACTIVE)
    ->dispatch(IconButtonComponentEvent::RESET);

echo w4_render($iconButton);
```

### 4.5 Ejemplos equivalentes en Blade (`x-w4-icon-button`)

```blade
<x-w4-icon-button
    label="Actualizar"
    icon="heroicon-o-arrow-path"
    theme="daisyui"
    variant="primary"
/>
```

```blade
<x-w4-icon-button
    label="No disponible"
    icon="heroicon-o-lock-closed"
    theme="daisyui"
    variant="neutral"
    :disabled="true"
/>
```

```blade
<x-w4-icon-button
    label="Procesando"
    icon="heroicon-o-arrow-path"
    theme="daisyui"
    variant="info"
    :loading="true"
/>
```

```blade
<x-w4-icon-button
    label="Activo"
    icon="heroicon-o-star"
    theme="daisyui"
    variant="accent"
    :active="true"
/>
```

```blade
<x-w4-icon-button
    label="Solo lectura"
    icon="heroicon-o-eye"
    theme="daisyui"
    variant="warning"
    :readonly="true"
/>
```

Para volver a estado base (`reset`) en Blade, renderiza el componente sin `:active`, `:loading`, `:disabled` ni `:readonly`.

## 5. 🧭 Ejemplos prácticos Daisy

IconButton de recarga:

```blade
<x-w4-icon-button
    label="Actualizar"
    icon="heroicon-o-arrow-path"
    theme="daisyui"
    variant="primary"
    size="md"
/>
```

IconButton de borrado:

```blade
<x-w4-icon-button
    label="Eliminar"
    icon="heroicon-o-trash"
    theme="daisyui"
    variant="error"
    size="sm"
/>
```

IconButton con `componentId` para auditoría/estado:

```blade
<x-w4-icon-button
    label="Editar"
    icon="heroicon-o-pencil-square"
    theme="daisyui"
    :componentId="'icon-button-9001'"
/>
```

Inspección backend de `componentId` en payload:

```php
$debug = w4_debug_payload(
    \W4\UiFramework\Components\UI\IconButton\IconButton::make('Editar')
        ->theme('daisyui')
        ->icon('heroicon-o-pencil-square')
        ->meta('component_id', 'icon-button-9001')
        ->attribute('data-component-id', 'icon-button-9001')
);
```

## 6. 🧩 Ejemplo en controlador Laravel

```php
use W4\UiFramework\Components\UI\IconButton\IconButton;
use W4\UiFramework\Facades\W4Ui;

public function index()
{
    $refreshButton = IconButton::make('Actualizar')
        ->theme('daisyui')
        ->icon('heroicon-o-arrow-path')
        ->variant('primary')
        ->size('md');

    return view('dashboard.index', [
        'refreshButtonHtml' => W4Ui::render($refreshButton),
    ]);
}
```

## 7. 📦 Notas de integración

- El componente usa payload estándar (`renderer`, `view`, `data`, `theme`).
- La vista final de IconButton imprime `<button>` y utiliza el valor de `icon` dentro de una etiqueta `<i>`.
- Si usas Tailwind/DaisyUI con purga de clases, asegúrate de incluir clases `btn-*`, `btn-square`, `loading` y `btn-active` en el escaneo/safelist de tu app consumidora.
- Con `W4_UI_LOG=true`, registra en `storage/logs/w4.ui.log` si tiene `componentId`.
