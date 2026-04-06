# PROJECT STRUCTURE — W4 UI FRAMEWORK

## 1) Objetivo

Documentar la estructura oficial del repositorio `W4 UI Framework`, definiendo:

- Propósito de cada carpeta principal.
- Fronteras de responsabilidad por módulo.
- Flujo de dependencias esperado.
- Reglas para incorporar nuevos archivos sin romper consistencia.

## 2) Vista general del repositorio

El proyecto se organiza en cinco capas:

- **Núcleo de framework (PHP/Laravel)**: `src/**`
- **Vistas y recursos de render**: `resources/views/**`
- **Assets CSS y build frontend**: `resources/assets/**`, `resources/dist/**`, `scripts/**`
- **Pruebas**: `tests/**`
- **Documentación y gobierno técnico**: `docs/**`

Archivos raíz relevantes:

- `composer.json` (paquete PHP, dependencias y scripts de test)
- `package.json` (pipeline de assets CSS)
- `vite.config.js` y `postcss.config.cjs` (build frontend)
- `README.md`, `CHANGELOG.md`, `SECURITY.md`, `SUPPORT.md`

## 3) Estructura detallada por directorio

## `/config`

- Contiene configuración publicable del paquete:
  - `w4-ui-framework.php`

Responsabilidad:

- Definir defaults de tema, renderer, scope, logging y prefijos de componentes.

## `/src`

Es la capa principal del framework.

### `/src/Components`

- Define componentes de dominio, separados por:
  - `Forms`
  - `UI`

Cada componente sigue patrón estructural:

- `<Componente>.php`
- `<Componente>ComponentEvent.php`
- `<Componente>ComponentState.php`
- `<Componente>InteractState.php`
- `<Componente>StateMachine.php`

Responsabilidad:

- Modelar datos, estado y comportamiento del componente, sin acoplarse a clases CSS concretas.

### `/src/Contracts`

- Interfaces del sistema (`ComponentInterface`, `ThemeInterface`, `RendererInterface`, etc.).

Responsabilidad:

- Establecer contratos estables entre core, temas y renderers.

### `/src/Core`

- Orquestación de runtime:
  - `ComponentRegistry`
  - `ComponentFactory`
  - `ThemeResolverPipeline`
  - `RendererPipeline`
  - `RuntimeRenderer`

Responsabilidad:

- Resolver componente -> tema -> salida de render de forma desacoplada.

### `/src/Managers`

- Registro y acceso a implementaciones de:
  - temas (`ThemeManager`)
  - renderers (`RendererManager`)

Responsabilidad:

- Ser punto de extensión para nuevos temas/renderers.

### `/src/Renderers`

- Implementaciones de salida final.
- Actualmente incluye `BladeRenderer`.

Responsabilidad:

- Transformar payload del core en estructura consumible por vistas/renderer objetivo.

### `/src/Themes`

- Temas soportados:
  - `Bootstrap`
  - `DaisyUI`
  - `Tailwind`

Cada tema contiene resolvers por componente (`Components/Forms`, `Components/UI`).

Responsabilidad:

- Resolver `classes` y `attributes` por componente y estado.

### `/src/View`

- Wrappers de componentes Blade:
  - `BaseW4BladeComponent`
  - `Render`
  - `Components/Forms/*`
  - `Components/UI/*`

Responsabilidad:

- Adaptar props de Blade a componentes del dominio y delegar render al framework.

### `/src/Support`

- Objetos utilitarios y traits compartidos:
  - `AttributeBag`, `ClassBag`, `ComponentId`, `ComponentMetadata`
  - `Traits/InteractsWith*`
  - `W4UiManager`

Responsabilidad:

- Proveer infraestructura transversal reutilizable y API runtime (`render`, `view`, `payload`).

### `/src/Providers` y `/src/Facades`

- `W4UiFrameworkServiceProvider`
- `W4Ui` facade

Responsabilidad:

- Integración con contenedor Laravel, registro de bindings, publicación de config y componentes Blade.

## `/resources`

## `/resources/views`

- Vistas Blade del paquete:
  - `components/ui/*.blade.php`
  - `components/forms/*.blade.php`
  - wrappers auxiliares en `components/blade/*`

Responsabilidad:

- Renderizar HTML final usando `data`, `theme`, `component` y `payload`.

## `/resources/assets/css`

- Fuentes CSS por framework/área:
  - `bootstrap/ui/*`
  - `daisy/forms/*`, `daisy/ui/*`
  - `tailwind/forms/*`, `tailwind/ui/*`
  - `build/*`

Responsabilidad:

- Mantener safelists y fuentes de estilos requeridas para build.

## `/resources/dist`

- Salida compilada (Vite) para distribución de assets:
  - `css/*`
  - `.vite/manifest.json`

Responsabilidad:

- Artefactos listos para consumo en runtime/publicación.

## `/scripts`

- Scripts auxiliares de build, por ejemplo:
  - `scope-css.mjs`

Responsabilidad:

- Automatizar transformaciones post-build (scoping y ajustes de CSS).

## `/tests`

- Pruebas de integración con Testbench/PHPUnit:
  - `TestCase.php`
  - `W4UiFrameworkServiceProviderIntegrationTest.php`

Responsabilidad:

- Validar wiring del provider, registro de componentes, render y compatibilidad básica.

## `/docs`

- ADRs y guías de implementación/adopción:
  - `ADR-10/*`
  - guías comparativas de componentes por tema.

Responsabilidad:

- Gobierno técnico, decisiones y lineamientos de desarrollo.

## `/stub`

- Recursos publicables para entornos consumidores (ej. `w4.ui.log`).

Responsabilidad:

- Proveer archivos plantilla que el paquete publica en proyecto host.

## 4) Flujo de dependencias recomendado

Dirección permitida:

- `Components` -> `Contracts/Support`
- `Themes` -> `Contracts` + datos del componente
- `Core` -> `Managers` + `Contracts`
- `View Components` -> `Components` + `Support/W4UiManager`
- `resources/views` consume payload, no lógica de dominio

Dirección a evitar:

- `Components` dependiendo de `Themes`.
- `Themes` dependiendo de `View`.
- `Views` implementando lógica de state machine.

## 5) Reglas de incorporación de archivos

Al agregar un nuevo componente:

1. Crear estructura completa en `src/Components/<UI|Forms>/<Componente>/`.
2. Registrar alias en `ComponentRegistry` (Service Provider).
3. Crear resolver en cada tema activo.
4. Crear wrapper Blade en `src/View/Components`.
5. Crear vista Blade en `resources/views/components`.
6. Añadir pruebas en `tests`.
7. Actualizar documentación en `docs/`.

Al agregar un nuevo tema:

1. Crear `src/Themes/<Tema>/`.
2. Implementar clase de tema y resolvers por componente base.
3. Registrar en `ThemeManager`.
4. Añadir safelist/assets necesarios.
5. Validar render y pruebas de integración.

## 6) Convenciones transversales

- Naming de aliases y vistas en `kebab-case`.
- Clases PHP en `PascalCase`.
- Separación estricta entre:
  - lógica de estado (Components),
  - lógica de estilo (Themes),
  - lógica de presentación (Views/Blade).
- Mantener consistencia en nombres entre clase, namespace, archivo, alias y vista.

## 7) Antipatrones a evitar

- Duplicar clases CSS en vistas y resolvers.
- Resolver estado en Blade en lugar de usar state machine.
- Introducir dependencias circulares entre `Core`, `Themes` y `View`.
- Registrar componentes sin pruebas ni documentación mínima.
- Crear estructuras paralelas fuera de carpetas estándar.

## 8) Definición de estructura saludable

La estructura del proyecto se considera saludable cuando:

- Cada módulo tiene responsabilidad única y clara.
- El flujo componente -> tema -> renderer -> vista es trazable.
- Los nuevos componentes/temas se integran sin refactors amplios.
- Las pruebas cubren wiring crítico del sistema.
- La documentación refleja la estructura real del repositorio.
