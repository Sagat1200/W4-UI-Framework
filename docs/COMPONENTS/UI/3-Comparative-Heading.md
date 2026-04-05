# 🚀 W4-UI-Framework

## ✨ Comparativa de Heading por tema

Este resumen unifica el comportamiento de `Heading` en:

- DaisyUI
- Bootstrap
- Tailwind

Componente base común:

`W4\UiFramework\Components\UI\Heading\Heading`

## 1. 🧱 API funcional común

Se mantiene igual en los 3 temas:

- Estados: `enabled`, `disabled`, `active`, `hidden`
- Eventos: `activate`, `deactivate`, `disable`, `enable`, `hide`, `show`, `reset`
- Métodos típicos: `text(...)`, `level(...)`, `variant(...)`, `size(...)`, `dispatch(...)`, `toArray()`, `toThemeContext()`
- Regla común: `level` define semántica y, si no se define `size`, aplica mapeo automático (`h1->xl`, `h2->md`, `h3->sm`, `h4/h5/h6->xs`)

## 2. 🎨 Mapeo visual por tema

|Aspecto|DaisyUI|Bootstrap|Tailwind|
|---|---|---|---|
|Resolver|`DaisyUI\...\HeadingThemeResolver`|`Bootstrap\...\HeadingThemeResolver`|`Tailwind\...\HeadingThemeResolver`|
|Clase base|`font-semibold leading-tight`|`fw-semibold`|`font-semibold leading-tight tracking-tight`|
|Variantes|`text-primary`, `text-secondary`, `text-accent`, `text-success`, `text-warning`, `text-error`, `text-info`, `text-base-content`|`text-primary`, `text-secondary`, `text-success`, `text-warning`, `text-danger`, `text-info`, `text-light`, `text-dark`, `text-body`|`text-blue-*`, `text-slate-*`, `text-violet-*`, `text-emerald-*`, `text-amber-*`, `text-rose-*`, `text-cyan-*`|
|Tamaños|`text-xs`, `text-sm`, `text-base`, `text-lg`, `text-xl`|`fs-6`, `fs-5`, `fs-4`, `fs-3`, `fs-2`|`text-sm`, `text-base`, `text-xl`, `text-2xl`, `text-3xl`|
|Estado `active`|Agrega `underline`|Agrega `text-decoration-underline`|Agrega `underline underline-offset-4`|
|Estado `hidden`|Agrega `hidden`|Agrega `d-none`|Agrega `hidden`|
|Merge de `class` usuario|Sí|Sí|Sí|

## 3. ♿ Atributos de accesibilidad y estado

En los 3 temas se resuelven de forma equivalente:

- `role`: por defecto `heading`
- `aria-level`: derivado de `level` (`h1`..`h6`) o el del usuario
- `aria-hidden`: `'true'` cuando estado es `hidden`
- `data-state`: estado actual

## 4. 🖥️ Uso rápido equivalente

### 4.1 DaisyUI

```blade
<x-w4-heading text="Título principal" level="h1" theme="daisyui" variant="primary" size="lg" />
```

### 4.2 Bootstrap

```blade
<x-w4-heading text="Título principal" level="h1" theme="bootstrap" variant="primary" size="lg" />
```

### 4.3 Tailwind

```blade
<x-w4-heading text="Título principal" level="h1" theme="tailwind" variant="primary" size="lg" />
```

## 5. 🔗 Referencias detalladas

- Daisy: `docs/COMPONENTS/UI/Daisy/3-Heading.md`
- Bootstrap: `docs/COMPONENTS/UI/Bootstrap/3-Heading.md`
- Tailwind: `docs/COMPONENTS/UI/Tailwind/3-Heading.md`
