# 🚀 W4-UI-Framework

## ✨ Comparativa de CheckBox por tema

Este resumen unifica el comportamiento de `CheckBox` en:

- DaisyUI
- Bootstrap
- Tailwind

Componente base común:

`W4\UiFramework\Components\Forms\CheckBox\CheckBox`

## 1. 🧱 API funcional común

Se mantiene igual en los 3 temas:

- Estados: `enabled`, `disabled`, `readonly`, `invalid`, `valid`, `loading`
- Eventos: `focus`, `blur`, `change`, `check`, `uncheck`, `toggle`, `set_indeterminate`, `clear_indeterminate`, `disable`, `enable`, `set_readonly`, `set_invalid`, `set_valid`, `start_loading`, `finish_loading`, `reset`
- Métodos típicos: `check()`, `uncheck()`, `toggle()`, `setIndeterminate()`, `clearIndeterminate()`, `dispatch(...)`, `state(...)`, `toArray()`, `toThemeContext()`

## 2. 🎨 Mapeo visual por tema

|Aspecto|DaisyUI|Bootstrap|Tailwind|
|---|---|---|---|
|Resolver|`DaisyUI\...\CheckBoxThemeResolver`|`Bootstrap\...\CheckBoxThemeResolver`|`Tailwind\...\CheckBoxThemeResolver`|
|Clase base|`checkbox`|`form-check-input`|`rounded border transition ...`|
|Variantes|`checkbox-neutral`, `checkbox-primary`, `checkbox-secondary`, `checkbox-accent`, `checkbox-success`, `checkbox-warning`, `checkbox-error`, `checkbox-info`|`is-valid`, `is-invalid`, `border-warning` (según variante)|`border-slate-*`, `border-blue-*`, `border-violet-*`, `border-cyan-*`, `border-emerald-*`, `border-amber-*`, `border-rose-*` + `focus:ring-*`|
|Tamaños|`checkbox-xs`, `checkbox-sm`, `checkbox-md`, `checkbox-lg` (`xl` mapea a `checkbox-lg`)|`form-check-input-sm`, `form-check-input-lg` (`md` sin extra)|`h/w` por `xs..xl` (`h-3 w-3` ... `h-7 w-7`)|
|Estado `loading`|Agrega `opacity-75`|Agrega `opacity-75`|Agrega `opacity-75 animate-pulse`|
|Estado `invalid`|Agrega `checkbox-error`|Agrega `is-invalid`|Agrega `border-rose-500 text-rose-600`|
|Estado `valid`|Agrega `checkbox-success`|Agrega `is-valid`|Agrega `border-emerald-500 text-emerald-600`|
|Estado interactivo `focused`|Agrega `ring`|Agrega `focus`|Agrega `ring-2`|
|Estado interactivo `pressed`|Agrega `scale-95`|No agrega clase visual extra|Agrega `scale-95`|
|Merge de `class` usuario|Sí|Sí|Sí|

## 3. ♿ Atributos de accesibilidad y estado

En los 3 temas se resuelven de forma equivalente:

- `type`: fijo en `checkbox`
- `checked`: `true` cuando `checked=true` y no está en indeterminado
- `disabled`: `true` para `disabled` y `loading`
- `readonly`: `true` para `readonly`
- `aria-invalid`: `'true'` cuando `invalid`
- `aria-busy`: `'true'` cuando `loading`
- `aria-checked`: `'mixed'` cuando `indeterminate`, o `'true'/'false'` según `checked`
- `data-indeterminate`, `data-focused`, `data-hovered`, `data-pressed`: derivados de `interact_state`

## 4. 🖥️ Uso rápido equivalente

### 4.1 DaisyUI

```blade
<x-w4-checkbox label="Acepto términos" theme="daisyui" variant="primary" size="md" :checked="true" />
```

### 4.2 Bootstrap

```blade
<x-w4-checkbox label="Acepto términos" theme="bootstrap" variant="primary" size="md" :checked="true" />
```

### 4.3 Tailwind

```blade
<x-w4-checkbox label="Acepto términos" theme="tailwind" variant="primary" size="md" :checked="true" />
```

## 5. 🔗 Referencias detalladas

- Daisy: `docs/COMPONENTS/Forms/Daisy/2-CheckBox.md`
- Bootstrap: `docs/COMPONENTS/Forms/Bootstrap/2-CheckBox.md`
- Tailwind: `docs/COMPONENTS/Forms/Tailwind/2-CheckBox.md`
