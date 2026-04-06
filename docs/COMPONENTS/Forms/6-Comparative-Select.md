# 🚀 W4-UI-Framework

## ✨ Comparativa de Select por tema

Este resumen unifica `Select` en:

- DaisyUI
- Bootstrap
- Tailwind

Componente base común:

`W4\UiFramework\Components\Forms\Select\Select`

## 1. 🧱 API funcional común

- Estados: `enabled`, `disabled`, `readonly`, `invalid`, `valid`, `loading`
- Eventos: `focus`, `blur`, `change`, `select`, `clear`, `disable`, `enable`, `set_readonly`, `set_invalid`, `set_valid`, `start_loading`, `finish_loading`, `reset`
- Métodos: `options(...)`, `addOption(...)`, `selected(...)`, `placeholder(...)`, `multiple(...)`, `dispatch(...)`, `state(...)`, `toArray()`, `toThemeContext()`

## 2. 🎨 Mapeo visual por tema

|Aspecto|DaisyUI|Bootstrap|Tailwind|
|---|---|---|---|
|Resolver|`DaisyUI\...\SelectThemeResolver`|`Bootstrap\...\SelectThemeResolver`|`Tailwind\...\SelectThemeResolver`|
|Clase base|`select select-bordered w-full`|`form-select`|`block w-full rounded-md border ...`|
|Variantes|`select-neutral`, `select-primary`, `select-secondary`, `select-accent`, `select-success`, `select-warning`, `select-error`, `select-info`|`is-valid`, `is-invalid`, `border-warning`|`border-slate-*`, `border-blue-*`, `border-violet-*`, `border-cyan-*`, `border-emerald-*`, `border-amber-*`, `border-rose-*`|
|Tamaños|`select-xs`, `select-sm`, `select-md`, `select-lg`|`form-select-sm`, `form-select-lg` (`md` sin extra)|`px/py/text-*` por `xs..xl`|
|Estado `loading`|`opacity-75`|`opacity-75`|`opacity-75 animate-pulse`|
|Estado `invalid`|`select-error`|`is-invalid`|`border-rose-500 text-rose-600`|
|Estado `valid`|`select-success`|`is-valid`|`border-emerald-500 text-emerald-600`|
|Merge de `class` usuario|Sí|Sí|Sí|

## 3. ♿ Atributos de accesibilidad y estado

- `name`, `id`, `multiple`
- `disabled`, `readonly`
- `aria-invalid`, `aria-busy`
- `data-focused`, `data-hovered`, `data-opened`

## 4. 🖥️ Uso rápido equivalente

### 4.1 DaisyUI

```blade
<x-w4-select theme="daisyui" label="Plan" :options="['basic'=>'Basic','pro'=>'Pro']" selected="pro" />
```

### 4.2 Bootstrap

```blade
<x-w4-select theme="bootstrap" label="Plan" :options="['basic'=>'Basic','pro'=>'Pro']" selected="pro" />
```

### 4.3 Tailwind

```blade
<x-w4-select theme="tailwind" label="Plan" :options="['basic'=>'Basic','pro'=>'Pro']" selected="pro" />
```

## 5. 🔗 Referencias detalladas

- Daisy: `docs/COMPONENTS/Forms/Daisy/6-Select.md`
- Bootstrap: `docs/COMPONENTS/Forms/Bootstrap/6-Select.md`
- Tailwind: `docs/COMPONENTS/Forms/Tailwind/6-Select.md`
