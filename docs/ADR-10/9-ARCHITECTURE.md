# ARCHITECTURE — W4 UI FRAMEWORK

## 1) Objetivo

Describir la arquitectura técnica de `W4 UI Framework` para facilitar:

- Comprensión del flujo interno de renderizado.
- Evolución segura de componentes, temas y renderers.
- Alineación entre implementación, pruebas y documentación.
- Toma de decisiones de diseño con trazabilidad.

## 2) Contexto arquitectónico

`W4 UI Framework` es una librería para Laravel orientada a abstraer componentes UI/Forms con soporte multi-tema y render basado en pipeline.

La arquitectura separa cuatro preocupaciones:

- **Modelo de componente**: datos, estado y eventos.
- **Resolución de tema**: clases y atributos por componente/estado.
- **Renderización**: construcción de salida final (Blade).
- **Adaptación de entrada**: wrappers Blade, helpers y facade para consumo.

## 3) Estilo arquitectónico

Se adopta un enfoque **modular por capas**, con patrón de **pipeline** para composición de ejecución:

1. Componente de dominio.
2. Resolución de tema.
3. Render.
4. Entrega de salida (`render`, `view`, `payload`).

Esto reduce acoplamiento y permite reemplazar/extender temas o renderers sin reescribir componentes.

## 4) Capas del sistema

## Capa de Dominio (Components)

Ubicación: `src/Components/**`

Responsabilidades:

- Representar el componente (`Button`, `Input`, etc.).
- Gestionar estado y transiciones (`StateMachine`).
- Exponer API de configuración de props/atributos.

No debe:

- Resolver clases CSS específicas de tema.
- Tomar decisiones de render Blade.

## Capa de Contratos

Ubicación: `src/Contracts/**`

Responsabilidades:

- Definir interfaces estables para:
  - componentes,
  - temas,
  - renderers,
  - resolvers.

Objetivo:

- Garantizar intercambiabilidad y extensión controlada.

## Capa Core (Orquestación)

Ubicación: `src/Core/**`

Piezas principales:

- `ComponentRegistry` y `ComponentFactory`
- `ThemeResolverPipeline`
- `RendererPipeline`
- `RuntimeRenderer`

Responsabilidades:

- Ensamblar flujo de ejecución de forma desacoplada.
- Aplicar resolución de tema y render según configuración/runtime.

## Capa de Temas

Ubicación: `src/Themes/**`

Responsabilidades:

- Traducir estado y variaciones del componente a:
  - `classes`
  - `attributes`

Regla:

- Los temas no implementan lógica de negocio del componente.

## Capa de Render/Presentación

Ubicación:

- `src/Renderers/**`
- `src/View/Components/**`
- `resources/views/components/**`

Responsabilidades:

- Adaptar entrada de Blade hacia componentes de dominio.
- Renderizar markup final usando payload normalizado.

## Capa de Soporte e Integración Laravel

Ubicación:

- `src/Support/**`
- `src/Providers/**`
- `src/Facades/**`
- `src/Helpers/**`

Responsabilidades:

- Registro en contenedor Laravel.
- Exposición de API de consumo (`w4_render`, `W4Ui::render`, Blade components).
- Infraestructura transversal (bags, traits, metadata, scope wrapper, logging).

## 5) Flujo de ejecución end-to-end

### Entrada

El consumo puede iniciar desde:

- Helper (`w4_render`, `w4_view`, `w4_payload`)
- Facade (`W4Ui`)
- Componente Blade (`<x-w4-button />`, etc.)

### Paso 1 — Construcción del componente

Se crea una instancia de componente de dominio con props y estado inicial.

### Paso 2 — Resolución de tema

`ThemeResolverPipeline` toma:

- componente,
- tema (global o por componente),

y devuelve una estructura temática consistente (`classes`, `attributes`).

### Paso 3 — Render pipeline

`RendererPipeline` selecciona renderer (actualmente `blade`) y construye payload final.

### Paso 4 — Entrega por manager

`W4UiManager` expone:

- `render(...)` -> HTML string
- `view(...)` -> View instance/string
- `payload(...)` -> estructura inspeccionable

Opcionalmente:

- aplica wrapper de scope CSS,
- escribe logging estructurado si está habilitado.

## 6) Contrato de payload arquitectónico

Forma esperada de salida:

- `renderer`
- `view`
- `component`
- `data`
- `theme`
  - `classes`
  - `attributes`

Este contrato es un punto clave de compatibilidad hacia atrás.

## 7) Integración con Laravel

El `ServiceProvider` es el ensamblador principal:

- registra alias de componentes en `ComponentRegistry`,
- registra temas en `ThemeManager`,
- registra renderers en `RendererManager`,
- configura pipelines y `RuntimeRenderer`,
- registra `W4UiManager` como servicio (`w4.ui`),
- publica configuración y recursos,
- registra componentes Blade con prefijo configurable.

## 8) Decisiones arquitectónicas clave

- Pipeline desacoplado para tema + renderer.
- Modelo orientado a estado por componente.
- Registro de componentes por alias y factoría.
- Blade como renderer inicial por defecto.
- Multi-tema con resolvers específicos por componente.
- Payload normalizado como contrato transversal.
- Scope CSS opcional para aislamiento visual.

## 9) Atributos de calidad

## Mantenibilidad

- Módulos separados por responsabilidad.
- Convenciones homogéneas para componentes y temas.

## Extensibilidad

- Agregar tema nuevo mediante `ThemeManager` + resolvers.
- Agregar renderer nuevo mediante `RendererManager`.
- Agregar componente nuevo siguiendo plantilla estructural estándar.

## Testabilidad

- Pruebas de integración validan wiring real del framework.
- Payload facilita aserciones robustas de render.

## Compatibilidad

- API pública debe evolucionar con estrategia de deprecación.
- Contratos críticos (aliases, payload, firmas) deben protegerse con regresión.

## 10) Riesgos arquitectónicos

- **Divergencia de paridad entre temas** por crecimiento asimétrico.
- **Duplicación de lógica de estado** entre componentes, vistas y resolvers.
- **Acoplamiento accidental** entre dominio y presentación.
- **Drift documental** entre arquitectura descrita y código real.

Mitigaciones:

- Checklist de paridad por componente/tema.
- Reglas de separación por capa.
- Refuerzo de pruebas end-to-end y de regresión.
- Mantenimiento activo de ADRs y guías.

## 11) Evolución arquitectónica prevista

Líneas de evolución compatibles con la arquitectura actual:

- Soporte de renderers adicionales.
- Mayor estandarización/reutilización entre ThemeResolvers.
- Cobertura ampliada de componentes Forms/UI.
- Herramientas de validación de paridad multi-tema.

Criterio rector:

- Evolucionar por extensión de capas, evitando romper contratos nucleares.

## 12) Definición de arquitectura saludable

La arquitectura se considera saludable cuando:

- El flujo componente -> tema -> renderer -> vista se mantiene claro y estable.
- Cada capa cumple responsabilidad única sin mezclar concerns.
- Nuevos componentes/temas/renderers se incorporan con cambios localizados.
- Las decisiones documentadas coinciden con implementación real y pruebas.
