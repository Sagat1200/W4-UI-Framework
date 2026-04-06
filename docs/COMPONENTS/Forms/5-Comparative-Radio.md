# 🚀 W4-UI-Framework

## ✨ Comparativa de Radio por tema

Este resumen unifica el comportamiento de `Radio` en:

- DaisyUI
- Bootstrap
- Tailwind

Componente base común:

`W4\UiFramework\Components\Forms\Radio\Radio`

## 1. 🧱 API funcional común

Se mantiene igual en los 3 temas:

- Estados: `enabled`, `disabled`, `readonly`, `invalid`, `valid`, `loading`
- Eventos: `focus`, `blur`, `change`, `select`, `clear`, `disable`, `enable`, `set_readonly`, `set_invalid`, `set_valid`, `start_loading`, `finish_loading`, `reset`
- Métodos típicos: `value(...)`, `group(...)`, `selected(...)`, `variant(...)`, `size(...)`, `dispatch(...)`, `state(...)`, `toArray()`, `toThemeContext()`

## 2. 🎨 Mapeo visual por tema

|Aspecto|DaisyUI|Bootstrap|Tailwind|
|---|---|---|---|
|Resolver|`DaisyUI\...\RadioThemeResolver`|`Bootstrap\...\RadioThemeResolver`|`Tailwind\...\RadioThemeResolver`|
|Clase base|`radio`|`form-check-input`|`rounded-full border transition ...`|
|Variantes|`radio-neutral`, `radio-primary`, `radio-secondary`, `radio-accent`, `radio-success`, `radio-warning`, `radio-error`, `radio-info`|`is-valid`, `is-invalid`, `border-warning` (según variante)|`border-slate-*`, `border-blue-*`, `border-violet-*`, `border-cyan-*`, `border-emerald-*`, `border-amber-*`, `border-rose-*` + `focus:ring-*`|
|Tamaños|`radio-xs`, `radio-sm`, `radio-md`, `radio-lg` (`xl` mapea a `radio-lg`)|`form-check-input-sm`, `form-check-input-lg` (`md` sin extra)|`h/w` por `xs..xl` (`h-3 w-3` ... `h-7 w-7`)|
|Estado `loading`|Agrega `opacity-75`|Agrega `opacity-75`|Agrega `opacity-75 animate-pulse`|
|Estado `invalid`|Agrega `radio-error`|Agrega `is-invalid`|Agrega `border-rose-500 text-rose-600`|
|Estado `valid`|Agrega `radio-success`|Agrega `is-valid`|Agrega `border-emerald-500 text-emerald-600`|
|Estado interactivo `focused`|Agrega `ring`|Agrega `focus`|Agrega `ring-2`|
|Estado interactivo `pressed`|Agrega `scale-95`|No agrega clase visual extra|Agrega `scale-95`|
|Merge de `class` usuario|Sí|Sí|Sí|

## 3. ♿ Atributos de accesibilidad y estado

En los 3 temas se resuelven de forma equivalente:

- `type`: fijo en `radio`
- `checked`: `true` cuando `selected=true`
- `disabled`: `true` para `disabled` y `loading`
- `readonly`: `true` para `readonly`
- `aria-invalid`: `'true'` cuando `invalid`
- `aria-busy`: `'true'` cuando `loading`
- `aria-checked`: `'true'`/`'false'` según `selected`
- `data-focused`, `data-hovered`, `data-pressed`: derivados de `interact_state`

## 4. 🖥️ Uso rápido equivalente

### 4.1 DaisyUI

```blade
<x-w4-radio label="Pro" theme="daisyui" group="plan" value="pro" variant="primary" :selected="true" />
```

### 4.2 Bootstrap

```blade
<x-w4-radio label="Pro" theme="bootstrap" group="plan" value="pro" variant="primary" :selected="true" />
```

### 4.3 Tailwind

```blade
<x-w4-radio label="Pro" theme="tailwind" group="plan" value="pro" variant="primary" :selected="true" />
```

## 5. 🔗 Referencias detalladas

- Daisy: `docs/COMPONENTS/Forms/Daisy/5-Radio.md`
- Bootstrap: `docs/COMPONENTS/Forms/Bootstrap/5-Radio.md`
- Tailwind: `docs/COMPONENTS/Forms/Tailwind/5-Radio.md`
