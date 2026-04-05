# 🚀 W4-UI-Framework

## ✨ Comparativa de FieldError por tema

Este resumen unifica el comportamiento de `FieldError` en:

- DaisyUI
- Bootstrap
- Tailwind

Componente base común:

`W4\UiFramework\Components\Forms\FielError\FieldError`

## 1. 🧱 API funcional común

Se mantiene igual en los 3 temas:

- Estados: `enabled`, `disabled`, `active`, `hidden`
- Eventos: `activate`, `deactivate`, `disable`, `enable`, `hide`, `show`, `reset`
- Métodos típicos: `message(...)`, `forField(...)`, `code(...)`, `hint(...)`, `variant(...)`, `size(...)`, `dispatch(...)`, `state(...)`, `toArray()`, `toThemeContext()`

## 2. 🎨 Mapeo visual por tema

|Aspecto|DaisyUI|Bootstrap|Tailwind|
|---|---|---|---|
|Resolver|`DaisyUI\...\FieldErrorThemeResolver`|`Bootstrap\...\FieldErrorThemeResolver`|`Tailwind\...\FieldErrorThemeResolver`|
|Clase base|`label-text-alt text-error`|`invalid-feedback d-block`|`mt-1 block text-rose-600`|
|Variantes|`text-base-content`, `text-primary`, `text-secondary`, `text-accent`, `text-success`, `text-warning`, `text-info`, `text-error`|`text-body-secondary`, `text-primary`, `text-secondary`, `text-info`, `text-success`, `text-warning`, `text-danger`|`text-slate-*`, `text-blue-*`, `text-violet-*`, `text-cyan-*`, `text-emerald-*`, `text-amber-*`, `text-rose-*`|
|Tamaños|`text-xs`, `text-sm`, `text-base`, `text-lg`, `text-xl`|`fs-6`, `fs-5`, `fs-4`, `fs-3`|`text-xs`, `text-sm`, `text-base`, `text-lg`, `text-xl`|
|Estado `disabled`|Agrega `opacity-50`|Agrega `opacity-50`|Agrega `opacity-50`|
|Estado `active`|Agrega `font-semibold`|Agrega `fw-semibold`|Agrega `font-semibold`|
|Estado `hidden`|Agrega `hidden`|Agrega `d-none`|Agrega `hidden`|
|Merge de `class` usuario|Sí|Sí|Sí|

## 3. ♿ Atributos de accesibilidad y estado

En los 3 temas se resuelven de forma equivalente:

- `role`: por defecto `alert`
- `aria-live`: `assertive` cuando `active`; `polite` en otro estado
- `aria-hidden`: `'true'` cuando estado es `hidden`
- `data-state`: estado actual del componente
- `data-for-field`: valor de `forField` cuando existe
- `data-error-code`: valor de `code` cuando existe

## 4. 🖥️ Uso rápido equivalente

### 4.1 DaisyUI

```blade
<x-w4-field-error message="Campo requerido" theme="daisyui" forField="email" code="E_REQUIRED" :active="true" />
```

### 4.2 Bootstrap

```blade
<x-w4-field-error message="Campo requerido" theme="bootstrap" forField="email" code="E_REQUIRED" :active="true" />
```

### 4.3 Tailwind

```blade
<x-w4-field-error message="Campo requerido" theme="tailwind" forField="email" code="E_REQUIRED" :active="true" />
```

## 5. 🔗 Referencias detalladas

- Daisy: `docs/COMPONENTS/Forms/Daisy/3-FieldError.md`
- Bootstrap: `docs/COMPONENTS/Forms/Bootstrap/3-FieldError.md`
- Tailwind: `docs/COMPONENTS/Forms/Tailwind/3-FieldError.md`
