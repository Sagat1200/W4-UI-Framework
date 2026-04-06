# DECISIONS LOG — W4 UI FRAMEWORK

## 1) Propósito

Consolidar las decisiones técnicas y de producto del paquete `W4 UI Framework` en formato trazable, para:

- Explicar el porqué de la arquitectura actual.
- Reducir decisiones implícitas no documentadas.
- Facilitar mantenimiento, onboarding y evolución.
- Dar contexto para cambios futuros y revisiones ADR.

## 2) Estado

Este documento registra decisiones **aceptadas** y **vigentes** salvo que se indique lo contrario.

Estados posibles sugeridos:

- `accepted`
- `superseded`
- `deprecated`
- `proposed`

## 3) Decisiones principales

## DEC-001 — Arquitectura por pipeline (tema + renderer)

- **Estado**: accepted
- **Fecha**: 2026-04-06
- **Contexto**: se requiere desacoplar la construcción del componente de su estilo final y del mecanismo de render.
- **Decisión**: separar ejecución en dos pasos:
  - resolución de tema (`ThemeResolverPipeline`),
  - render (`RendererPipeline`), orquestado por `RuntimeRenderer`.
- **Consecuencia**:
  - facilita extensibilidad de temas/renderers,
  - reduce acoplamiento entre lógica de componente y vista.

## DEC-002 — Componentes orientados a estado (state machine)

- **Estado**: accepted
- **Fecha**: 2026-04-06
- **Contexto**: componentes interactivos requieren transiciones predecibles (`active`, `loading`, `invalid`, etc.).
- **Decisión**: estandarizar estructura por componente con:
  - `ComponentEvent`,
  - `ComponentState`,
  - `InteractState`,
  - `StateMachine`.
- **Consecuencia**:
  - comportamiento consistente entre componentes UI/Forms,
  - mayor testabilidad de flujos de estado.

## DEC-003 — Registro de componentes por alias

- **Estado**: accepted
- **Fecha**: 2026-04-06
- **Contexto**: se necesita resolución dinámica de componentes sin acoplar consumidores a clases concretas.
- **Decisión**: usar `ComponentRegistry` + `ComponentFactory` con alias kebab-case (`button`, `icon-button`, `field-error`, etc.).
- **Consecuencia**:
  - API de consumo más simple y uniforme,
  - incorporación controlada de nuevos componentes.

## DEC-004 — Blade como renderer base

- **Estado**: accepted
- **Fecha**: 2026-04-06
- **Contexto**: Laravel Blade es el mecanismo de vista dominante en el ecosistema objetivo.
- **Decisión**: establecer `BladeRenderer` como renderer por defecto y soportar componentes Blade con prefijo configurable.
- **Consecuencia**:
  - rápida adopción en proyectos Laravel,
  - base preparada para incluir renderers alternativos sin romper el contrato principal.

## DEC-005 — Temas iniciales: Bootstrap, DaisyUI y Tailwind

- **Estado**: accepted
- **Fecha**: 2026-04-06
- **Contexto**: se busca cubrir estilos ampliamente usados por equipos con diferentes stacks CSS.
- **Decisión**: soportar tres temas iniciales registrados en `ThemeManager`:
  - `bootstrap`,
  - `daisyui`,
  - `tailwind`.
- **Consecuencia**:
  - mayor portabilidad de componentes,
  - obligación de gestionar paridad funcional y de accesibilidad entre temas.

## DEC-006 — Payload normalizado como contrato de salida

- **Estado**: accepted
- **Fecha**: 2026-04-06
- **Contexto**: consumidores requieren inspección uniforme para debug, testing e integración.
- **Decisión**: exponer estructura consistente mediante `w4_payload(...)` y rutas de render/view:
  - `renderer`,
  - `view`,
  - `component`,
  - `data`,
  - `theme` (`classes`, `attributes`).
- **Consecuencia**:
  - facilita validaciones automatizadas y observabilidad,
  - exige compatibilidad hacia atrás en claves críticas.

## DEC-007 — Scope wrapper opcional para aislamiento visual

- **Estado**: accepted
- **Fecha**: 2026-04-06
- **Contexto**: en entornos multi-librería pueden existir colisiones CSS.
- **Decisión**: aplicar wrapper de scope configurable en tiempo de render (`w4_ui_scope_enabled`, clases por tema).
- **Consecuencia**:
  - mejora encapsulamiento visual,
  - requiere mantener safelists y clases sincronizadas con resolvers.

## DEC-008 — Logging de payload condicionado por configuración

- **Estado**: accepted
- **Fecha**: 2026-04-06
- **Contexto**: se necesita trazabilidad de render sin penalizar entornos productivos por defecto.
- **Decisión**: habilitar logging estructurado solo con flag (`w4_ui_log`) y salida dedicada (`storage/logs/w4.ui.log`).
- **Consecuencia**:
  - mejor diagnóstico cuando se habilita,
  - comportamiento limpio y silencioso por defecto.

## DEC-009 — Estrategia de pruebas centrada en integración

- **Estado**: accepted
- **Fecha**: 2026-04-06
- **Contexto**: el valor del paquete está en el ensamblaje entre provider, managers, pipeline, tema, vistas y Blade components.
- **Decisión**: priorizar pruebas de integración (Orchestra Testbench + PHPUnit) para validar flujo end-to-end.
- **Consecuencia**:
  - mayor confianza en wiring real del paquete,
  - necesidad de complementar con pruebas específicas por componente/tema según crezca la superficie.

## DEC-010 — Evolución controlada por compatibilidad

- **Estado**: accepted
- **Fecha**: 2026-04-06
- **Contexto**: consumidores externos dependen de estabilidad en alias, payload y comportamiento de componentes.
- **Decisión**: adoptar política de cambios:
  - evitar breaking changes sin deprecación,
  - documentar migraciones,
  - proteger contratos con pruebas de regresión.
- **Consecuencia**:
  - releases más confiables,
  - disciplina de gobierno técnico obligatoria.

## 4) Decisiones pendientes (proposed)

- Definir renderer alternativo inicial además de Blade.
- Formalizar matriz de paridad mínima por tema y componente.
- Establecer política de versionado y deprecaciones con plantilla estándar.
- Decidir nivel mínimo de cobertura objetivo por módulo.

## 5) Plantilla para nuevas decisiones

Usar el siguiente formato para nuevas entradas:

- **ID**: DEC-XXX
- **Título**: breve y específico
- **Estado**: proposed | accepted | superseded | deprecated
- **Fecha**: YYYY-MM-DD
- **Contexto**: problema o necesidad
- **Decisión**: alternativa elegida
- **Alternativas consideradas**: opciones descartadas y motivos
- **Consecuencias**: impactos positivos y trade-offs
- **Notas de implementación**: referencias a código/pruebas/documentación

## 6) Criterios de calidad del decision log

- Cada decisión debe ser verificable contra implementación real.
- Cambios de estado deben preservar trazabilidad histórica.
- No duplicar decisiones equivalentes con distinto nombre.
- Toda decisión con impacto en API pública debe reflejarse en roadmap y release process.
