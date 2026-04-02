# 🏷️ NAMING_CONVENTIONS.md

## Convenciones de Nombres

Este documento define las reglas oficiales de nomenclatura dentro de **W4‑UI‑Framework**. Mantener convenciones estrictas evita ambigüedad, mejora la legibilidad y facilita la extensión del framework.

---

## 1. Componentes

Los componentes deben usar **PascalCase** y representar claramente el elemento UI.

Ejemplos:

Button
Input
Card
Alert
Badge
Dropdown
Modal

Ubicación:

src/Components/{ComponentName}/

Ejemplo:

src/Components/Button/Button.php

---

## 2. Estados del Componente

Cada componente debe tener una enumeración que represente su estado funcional.

Formato obligatorio:

{Component}ComponentState

Ejemplos:

ButtonComponentState
InputComponentState
ModalComponentState

Ubicación:

src/Components/{Component}/{Component}ComponentState.php

---

## 3. Estados de Interacción

Los estados de interacción representan comportamientos derivados del usuario.

Formato obligatorio:

{Component}InteractState

Ejemplos:

ButtonInteractState
InputInteractState
DropdownInteractState

Ubicación:

src/Components/{Component}/{Component}InteractState.php

---

## 4. Temas

Los temas deben terminar en `Theme`.

Formato:

{ThemeName}Theme

Ejemplos:

BootstrapTheme
DaisyTheme
TailwindTheme

Ubicación:

src/Themes/{ThemeName}/

---

## 5. Resolvers de Componentes

Los resolvers traducen metadata del componente en clases CSS.

Formato:

{Component}ThemeResolver

Ejemplos:

ButtonThemeResolver
InputThemeResolver

Ubicación:

src/Themes/{Theme}/Components/

Ejemplo:

src/Themes/Bootstrap/Components/ButtonThemeResolver.php

---

## 6. Renderers

Los renderers convierten componentes en salida final.

Formato:

{RendererType}Renderer

Ejemplos:

BladeRenderer
LivewireRenderer
InertiaReactRenderer
InertiaVueRenderer

Ubicación:

src/Renderers/

---

## 7. Managers

Los managers coordinan funcionalidades globales.

Formato:

{Name}Manager

Ejemplos:

RendererManager
ThemeManager
ComponentRegistryManager

Ubicación:

src/Managers/

---

## 8. Interfaces (Contracts)

Las interfaces deben terminar con `Interface`.

Ejemplos:

ComponentInterface
RendererInterface
ThemeInterface
ThemeResolverInterface

Ubicación:

src/Contracts/

---

## 9. Traits

Los traits deben iniciar con `InteractsWith` o describir claramente su función.

Ejemplos:

InteractsWithState
InteractsWithTheme
InteractsWithAttributes

Ubicación:

src/Support/Traits/

---

## 10. Archivos de Configuración

Los archivos de configuración deben usar **snake_case**.

Ejemplo:

config/w4-ui-framework.php

---

## 11. Namespaces

Namespace base del proyecto:

W4\UIFramework

Ejemplos:

W4\UIFramework\Components\Button
W4\UIFramework\Themes\Bootstrap
W4\UIFramework\Renderers

---

## 12. Component IDs

Los identificadores internos de componentes deben usar **kebab-case**.

Ejemplos:

w4-button
w4-input
w4-card

Esto permite interoperabilidad con:

* HTML
* Blade
* Livewire
* React
* Vue

---

## 13. Convención para Bridges

Los paquetes bridge deben usar el formato:

w4/{renderer}-bridge

Ejemplos:

w4/livewire-bridge
w4/inertia-bridge

Namespace sugerido:

W4\UIFramework\LivewireBridge
W4\UIFramework\InertiaBridge

---

## 14. Principio General

Si una nueva clase no encaja claramente en una convención existente, se debe:

1. revisar este documento
2. agregar una nueva convención explícita
3. evitar nombres ambiguos

Las convenciones son obligatorias para mantener coherencia en el framework.
