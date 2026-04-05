# 🚀 W4-UI-Framework

## ✨ Comparativa de Text por tema

Este resumen unifica el comportamiento de `Text` en:

- DaisyUI
- Bootstrap
- Tailwind

Componente base común:

`W4\UiFramework\Components\UI\Text\Text`

## 1. 🧱 API funcional común

Se mantiene igual en los 3 temas:

- Estados: `enabled`, `disabled`, `active`, `hidden`
- Eventos: `activate`, `deactivate`, `disable`, `enable`, `hide`, `show`, `reset`
- Métodos típicos: `text(...)`, `variant(...)`, `size(...)`, `dispatch(...)`, `toArray()`, `toThemeContext()`

## 2. 🎨 Mapeo visual por tema

|Aspecto|DaisyUI|Bootstrap|Tailwind|
|---|---|---|---|
|Resolver|`DaisyUI\...\TextThemeResolver`|`Bootstrap\...\TextThemeResolver`|`Tailwind\...\TextThemeResolver`|
|Clase base|`inline-block`|`d-inline-block`|`inline-block leading-snug`|
|Variantes|`text-base-content`, `text-primary`, `text-secondary`, `text-accent`, `text-success`, `text-warning`, `text-error`, `text-info`|`text-body`, `text-primary`, `text-secondary`, `text-success`, `text-warning`, `text-danger`, `text-info`, `text-light`, `text-dark`|`text-slate-900`, `text-blue-600`, `text-slate-700`, `text-violet-600`, `text-emerald-600`, `text-amber-600`, `text-rose-600`, `text-cyan-600`|
|Tamaños|`text-xs`, `text-sm`, `text-base`, `text-lg`, `text-xl`|`fs-6`, `fs-5`, `fs-4`, `fs-3`, `fs-2`|`text-xs`, `text-sm`, `text-base`, `text-lg`, `text-xl`|
|Estado `disabled`|Agrega `opacity-50`|Agrega `opacity-50`|Agrega `opacity-50`|
|Estado `active`|Agrega `font-semibold`|Agrega `fw-semibold`|Agrega `font-semibold`|
|Estado `hidden`|Agrega `hidden`|Agrega `d-none`|Agrega `hidden`|
|Merge de `class` usuario|Sí|Sí|Sí|

## 3. ♿ Atributos de accesibilidad y estado

En los 3 temas se resuelven de forma equivalente:

- `role`: por defecto `text`
- `aria-hidden`: `'true'` cuando estado es `hidden`
- `data-state`: estado actual del componente

## 4. 🖥️ Uso rápido equivalente

### 4.1 DaisyUI

```blade
<x-w4-text
    theme="daisyui"
    label="Estado"
    text="Completado"
    variant="primary"
    size="md"
/>
```

### 4.2 Bootstrap

```blade
<x-w4-text
    theme="bootstrap"
    label="Estado"
    text="Completado"
    variant="primary"
    size="md"
/>
```

### 4.3 Tailwind

```blade
<x-w4-text
    theme="tailwind"
    label="Estado"
    text="Completado"
    variant="primary"
    size="md"
/>
```

## 5. 🔗 Referencias detalladas

- Daisy: `docs/COMPONENTS/UI/Daisy/8-Text.md`
- Bootstrap: `docs/COMPONENTS/UI/Bootstrap/8-Text.md`
- Tailwind: `docs/COMPONENTS/UI/Tailwind/8-Text.md`
