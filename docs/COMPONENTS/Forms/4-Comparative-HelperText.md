# 🚀 W4-UI-Framework

## ✨ Comparativa de HelperText por tema

Este resumen unifica el comportamiento de `HelperText` en:

- DaisyUI
- Bootstrap
- Tailwind

Componente base común:

`W4\UiFramework\Components\Forms\HelperText\HelperText`

## 1. 🧱 API funcional común

Se mantiene igual en los 3 temas:

- Estados: `enabled`, `disabled`, `active`, `hidden`
- Eventos: `activate`, `deactivate`, `disable`, `enable`, `hide`, `show`, `reset`
- Métodos típicos: `text(...)`, `forField(...)`, `icon(...)`, `variant(...)`, `size(...)`, `dispatch(...)`, `state(...)`, `toArray()`, `toThemeContext()`

## 2. 🎨 Mapeo visual por tema

|Aspecto|DaisyUI|Bootstrap|Tailwind|
|---|---|---|---|
|Resolver|`DaisyUI\...\HelperTextThemeResolver`|`Bootstrap\...\HelperTextThemeResolver`|`Tailwind\...\HelperTextThemeResolver`|
|Clase base|`label-text-alt`|`form-text`|`mt-1 block`|
|Variantes|`text-base-content`, `text-primary`, `text-secondary`, `text-accent`, `text-success`, `text-warning`, `text-error`, `text-info`|`text-body-secondary`, `text-primary`, `text-secondary`, `text-info`, `text-success`, `text-warning`, `text-danger`|`text-slate-*`, `text-blue-*`, `text-violet-*`, `text-cyan-*`, `text-emerald-*`, `text-amber-*`, `text-rose-*`|
|Tamaños|`text-xs`, `text-sm`, `text-base`, `text-lg`, `text-xl`|`fs-6`, `fs-5`, `fs-4`, `fs-3`|`text-xs`, `text-sm`, `text-base`, `text-lg`, `text-xl`|
|Estado `disabled`|Agrega `opacity-50`|Agrega `opacity-50`|Agrega `opacity-50`|
|Estado `active`|Agrega `font-medium`|Agrega `fw-medium`|Agrega `font-medium`|
|Estado `hidden`|Agrega `hidden`|Agrega `d-none`|Agrega `hidden`|
|Merge de `class` usuario|Sí|Sí|Sí|

## 3. ♿ Atributos de accesibilidad y estado

En los 3 temas se resuelven de forma equivalente:

- `role`: por defecto `note`
- `aria-live`: `polite` cuando `active`, `off` en otro estado
- `aria-hidden`: `'true'` cuando `hidden`
- `data-state`: estado actual
- `data-for-field`: valor de `forField`
- `data-focused`, `data-hovered`: derivados de `interact_state`

## 4. 🖥️ Uso rápido equivalente

### 4.1 DaisyUI

```blade
<x-w4-helper-text text="Puedes usar 8+ caracteres" theme="daisyui" forField="password" variant="info" />
```

### 4.2 Bootstrap

```blade
<x-w4-helper-text text="Puedes usar 8+ caracteres" theme="bootstrap" forField="password" variant="info" />
```

### 4.3 Tailwind

```blade
<x-w4-helper-text text="Puedes usar 8+ caracteres" theme="tailwind" forField="password" variant="info" />
```

## 5. 🔗 Referencias detalladas

- Daisy: `docs/COMPONENTS/Forms/Daisy/4-HelperText.md`
- Bootstrap: `docs/COMPONENTS/Forms/Bootstrap/4-HelperText.md`
- Tailwind: `docs/COMPONENTS/Forms/Tailwind/4-HelperText.md`
