# 🚀 W4-UI-Framework

## ✨ Comparativa de Input por tema

Este resumen unifica el comportamiento de `Input` en:

- DaisyUI
- Bootstrap
- Tailwind

Componente base común:

`W4\UiFramework\Components\Forms\Input\Input`

## 1. 🧱 API funcional común

Se mantiene igual en los 3 temas:

- Estados: `enabled`, `disabled`, `readonly`, `invalid`, `valid`, `loading`
- Eventos: `focus`, `blur`, `input`, `disable`, `enable`, `set_readonly`, `set_invalid`, `set_valid`, `start_loading`, `finish_loading`, `reset`
- Métodos típicos: `variant(...)`, `size(...)`, `dispatch(...)`, `state(...)`, `toArray()`, `toThemeContext()`

## 2. 🎨 Mapeo visual por tema

|Aspecto|DaisyUI|Bootstrap|Tailwind|
|---|---|---|---|
|Resolver|`DaisyUI\...\InputThemeResolver`|`Bootstrap\...\InputThemeResolver`|`Tailwind\...\InputThemeResolver`|
|Clase base|`input input-bordered w-full`|`form-control`|`block w-full rounded-md border transition ...`|
|Variantes|`input-neutral`, `input-primary`, `input-secondary`, `input-accent`, `input-success`, `input-warning`, `input-error`|`is-valid`, `is-invalid`, `border-warning` (según variante)|`border-slate-*`, `border-blue-*`, `border-violet-*`, `border-emerald-*`, `border-amber-*`, `border-rose-*` + `focus:ring-*`|
|Tamaños|`input-xs`, `input-sm`, `input-md`, `input-lg`, `input-xl`|`form-control-sm`, `form-control-lg` (`md` sin extra)|`px/py` + `text-*` por `xs..xl`|
|Estado `loading`|Agrega `opacity-75`|Agrega `opacity-75`|Agrega `opacity-75 animate-pulse`|
|Estado `invalid`|Agrega `input-error`|Agrega `is-invalid`|Fuerza `border-rose-500 focus:ring-rose-500`|
|Estado `valid`|Agrega `input-success`|Agrega `is-valid`|Fuerza `border-emerald-500 focus:ring-emerald-500`|
|Estado interactivo `focused`|Agrega `ring`|Agrega `focus`|Agrega `ring-2`|
|Merge de `class` usuario|Sí|Sí|Sí|
|Regla especial ancho/alto custom|Remueve `w-full` y `input-*` si detecta clases `w-*`/`h-*`|Sin remoción especial|Remueve `w-full` y clases de tamaño si detecta `w-*`/`h-*`|

## 3. ♿ Atributos de accesibilidad y estado

En los 3 temas se resuelven de forma equivalente:

- `type`: usa contexto/atributo y por defecto `text`
- `disabled`: `true` para `disabled` y `loading`
- `readonly`: `true` para `readonly`
- `aria-invalid`: `'true'` cuando `invalid`
- `aria-busy`: `'true'` cuando `loading`
- `data-focused`, `data-hovered`, `data-filled`: derivados de `interact_state`

## 4. 🖥️ Uso rápido equivalente

### 4.1 DaisyUI

```blade
<x-w4-input label="Correo" theme="daisyui" variant="primary" size="md" />
```

### 4.2 Bootstrap

```blade
<x-w4-input label="Correo" theme="bootstrap" variant="primary" size="md" />
```

### 4.3 Tailwind

```blade
<x-w4-input label="Correo" theme="tailwind" variant="primary" size="md" />
```

## 5. 🔗 Referencias detalladas

- Daisy: `docs/COMPONENTS/Forms/Daisy/1-Input.md`
- Bootstrap: `docs/COMPONENTS/Forms/Bootstrap/1-Input.md`
- Tailwind: `docs/COMPONENTS/Forms/Tailwind/1-Input.md`
