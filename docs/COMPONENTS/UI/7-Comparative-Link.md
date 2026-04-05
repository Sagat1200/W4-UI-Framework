# 🚀 W4-UI-Framework

## ✨ Comparativa de Link por tema

Este resumen unifica el comportamiento de `Link` en:

- DaisyUI
- Bootstrap
- Tailwind

Componente base común:

`W4\UiFramework\Components\UI\Link\Link`

## 1. 🧱 API funcional común

Se mantiene igual en los 3 temas:

- Estados: `enabled`, `disabled`, `active`, `hidden`
- Eventos: `activate`, `deactivate`, `disable`, `enable`, `hide`, `show`, `reset`
- Métodos típicos: `text(...)`, `href(...)`, `target(...)`, `rel(...)`, `variant(...)`, `size(...)`, `dispatch(...)`, `toArray()`, `toThemeContext()`

## 2. 🎨 Mapeo visual por tema

|Aspecto|DaisyUI|Bootstrap|Tailwind|
|---|---|---|---|
|Resolver|`DaisyUI\...\LinkThemeResolver`|`Bootstrap\...\LinkThemeResolver`|`Tailwind\...\LinkThemeResolver`|
|Clase base|`link`|`link-offset-2`|`inline-flex items-center underline underline-offset-4 transition`|
|Variantes|`link-neutral`, `link-primary`, `link-secondary`, `link-accent`, `link-success`, `link-warning`, `link-error`, `link-info`|`link-primary`, `link-secondary`, `link-success`, `link-warning`, `link-danger`, `link-info`, `link-light`, `link-dark`, `link-body-emphasis`|`text-blue-*`, `text-slate-*`, `text-violet-*`, `text-emerald-*`, `text-amber-*`, `text-rose-*`, `text-cyan-*`|
|Tamaños|`text-xs`, `text-sm`, `text-base`, `text-lg`, `text-xl`|`fs-6`, `fs-5`, `fs-4`, `fs-3`, `fs-2`|`text-xs`, `text-sm`, `text-base`, `text-lg`, `text-xl`|
|Estado `disabled`|`opacity-50 pointer-events-none`|`disabled opacity-50`|`opacity-50 pointer-events-none`|
|Estado `active`|`link-hover font-semibold`|`text-decoration-underline`|`font-semibold`|
|Estado `hidden`|`hidden`|`d-none`|`hidden`|
|Merge de `class` usuario|Sí|Sí|Sí|

## 3. ♿ Atributos de accesibilidad y estado

En los 3 temas se resuelven de forma equivalente:

- `href`: usa `href` del usuario o valor del componente
- `target`: usa `target` del usuario o valor del componente
- `rel`: usa `rel` del usuario o valor del componente
- `aria-disabled`: `'true'` cuando estado es `disabled`
- `tabindex`: `-1` cuando estado es `disabled`
- `aria-hidden`: `'true'` cuando estado es `hidden`
- `data-state`: estado actual del componente

## 4. 🖥️ Uso rápido equivalente

### 4.1 DaisyUI

```blade
<x-w4-link
    theme="daisyui"
    label="Repositorio"
    href="https://github.com"
    variant="primary"
    size="md"
/>
```

### 4.2 Bootstrap

```blade
<x-w4-link
    theme="bootstrap"
    label="Repositorio"
    href="https://github.com"
    variant="primary"
    size="md"
/>
```

### 4.3 Tailwind

```blade
<x-w4-link
    theme="tailwind"
    label="Repositorio"
    href="https://github.com"
    variant="primary"
    size="md"
/>
```

## 5. 🔗 Referencias detalladas

- Daisy: `docs/COMPONENTS/UI/Daisy/7-Link.md`
- Bootstrap: `docs/COMPONENTS/UI/Bootstrap/7-Link.md`
- Tailwind: `docs/COMPONENTS/UI/Tailwind/7-Link.md`
