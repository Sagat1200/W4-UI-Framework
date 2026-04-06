# ROADMAP DEL PROYECTO — W4 UI FRAMEWORK

## 1) Objetivo del roadmap

Definir la evolución del paquete **W4 UI Framework** como capa de abstracción de componentes de interfaz para Laravel, con foco en:

- Consistencia de API para componentes UI y Forms.
- Escalabilidad en temas (Bootstrap, DaisyUI, Tailwind y futuros).
- Calidad técnica (tests, contratos, estabilidad y DX).
- Preparación para adopción interna y externa.

## 2) Estado actual (línea base)

El proyecto ya cuenta con:

- Registro de componentes por alias y factoría.
- Pipeline de resolución de temas y renderizado.
- Renderer Blade operativo.
- Componentes UI y Forms con state machine por componente.
- Soporte de temas Bootstrap, DaisyUI y Tailwind.
- Helpers globales (`w4_render`, `w4_view`, `w4_payload`).
- Pruebas de integración del Service Provider.
- Pipeline de build CSS con Vite/Tailwind/DaisyUI.

Esta base permite priorizar robustez, cobertura y estandarización antes de ampliar superficie funcional.

## 3) Principios de ejecución

- **Compatibilidad hacia atrás**: evitar breaking changes en API pública.
- **Estandarización primero**: contratos, naming y estructura homogénea.
- **Test-driven hardening**: cada mejora relevante debe venir acompañada de cobertura.
- **Roadmap incremental**: entregas pequeñas, medibles y publicables.
- **Documentación viva**: alinear ADRs, guías y comportamiento real del código.

## 4) Horizonte de trabajo

## Fase 1 — Consolidación del núcleo

### Objetivo de la Fase 1

Fortalecer confiabilidad del core y eliminar deuda estructural de bajo costo.

### Entregables de la Fase 1

- Homologación de nomenclaturas inconsistentes (por ejemplo, rutas/namespaces de componentes).
- Cobertura de pruebas para rutas críticas del pipeline:
  - registro de componentes,
  - resolución de tema,
  - renderizado,
  - wrappers/scope,
  - logging de payload.
- Validaciones explícitas para errores de configuración (tema/renderer no registrados).
- Revisión y limpieza de contratos para evitar acoplamiento accidental.

### Criterios de salida de la Fase 1

- Suite de pruebas estable.
- API pública documentada y coherente.
- Cero inconsistencias críticas de naming en componentes activos.

## Fase 2 — Expansión funcional de componentes

### Objetivo de la Fase 2

Completar y robustecer catálogo de componentes y estados de interacción.

### Entregables de la Fase 2

- Incorporación consistente de componentes ya modelados en código pero no expuestos de forma integral (ej. textarea/toggle si aplica en vistas/registro/documentación).
- Normalización de props y estados compartidos entre componentes similares.
- Mejoras de accesibilidad:
  - atributos ARIA por estado,
  - labels/errores asociados de forma explícita,
  - foco y navegación por teclado según tipo de componente.
- Matriz de compatibilidad por tema para variantes y tamaños.

### Criterios de salida de la Fase 2

- Catálogo funcional unificado en UI + Forms.
- Paridad mínima entre temas soportados para componentes base.
- Reglas de accesibilidad verificables en pruebas.

## Fase 3 — Motor de temas y diseño escalable

### Objetivo de la Fase 3

Reducir fricción para crear/ajustar temas y mejorar mantenibilidad de resolvers.

### Entregables de la Fase 3

- Convenciones formales para `ThemeResolver` por tipo de componente.
- Unificación de estrategia de clases utilitarias y atributos por estado.
- Mejoras al sistema de safelist/scoping para reducir colisiones CSS.
- Plantilla base para facilitar incorporación de un nuevo tema.

### Criterios de salida de la Fase 3

- Menor duplicación entre resolvers.
- Flujo definido para crear un tema nuevo con esfuerzo predecible.
- Estabilidad visual en escenarios multi-tema.

## Fase 4 — DX y experiencia de integración

### Objetivo de la Fase 4

Optimizar experiencia de desarrollo para equipos que consumen el paquete.

### Entregables de la Fase 4

- API más predecible para componentes Blade y helper/facade.
- Guías de uso por casos reales (formularios, acciones, layout básico).
- Validaciones y mensajes de error más claros en tiempo de integración.
- Fortalecimiento de configuración por entorno (tema global, prefijos, scope, logs).

### Criterios de salida de la Fase 4

- Menor fricción de adopción en proyectos Laravel.
- Menor tiempo de onboarding para nuevos desarrolladores.

## Fase 5 — Release, gobierno y adopción

### Objetivo de la Fase 5

Institucionalizar ciclo de versiones y asegurar evolución sostenible.

### Entregables de la Fase 5

- Política de versionado y changelog alineada a SemVer.
- Checklist de release (tests, build assets, validaciones de integración).
- Criterios de deprecación y migración.
- Definición de soporte y canal de incidencias.

### Criterios de salida de la Fase 5

- Proceso de release repetible y trazable.
- Cambios de versión con impacto controlado.

## 5) Backlog priorizado transversal

1. Aumentar cobertura de integración y casos de error del pipeline.
2. Estandarizar naming y contratos entre componentes Forms/UI.
3. Completar exposición end-to-end de componentes existentes en `src`.
4. Consolidar guía de temas y estrategia de scoping CSS.
5. Endurecer validaciones de configuración y mensajes de diagnóstico.
6. Preparar plantillas de release y control de compatibilidad.

## 6) Métricas de avance

- **Calidad**: cobertura de tests, regresiones por release, fallos críticos.
- **Consistencia**: porcentaje de componentes con API y naming homologado.
- **Paridad visual**: componentes base con soporte equivalente en cada tema.
- **DX**: incidencias de integración, claridad de errores, tiempo de adopción.
- **Operación**: releases exitosos y sin rollback.

## 7) Riesgos y mitigación

- **Riesgo**: divergencia entre temas por crecimiento asimétrico.  
  **Mitigación**: matriz de paridad por componente y gate de release.

- **Riesgo**: deuda técnica por duplicación en resolvers.  
  **Mitigación**: convenciones de implementación y revisiones por checklist.

- **Riesgo**: cambios incompatibles en API pública.  
  **Mitigación**: política de deprecación + pruebas de compatibilidad.

- **Riesgo**: documentación desalineada con implementación real.  
  **Mitigación**: actualización obligatoria de ADR/guías en cada release.

## 8) Hitos sugeridos (secuencia)

- **Hito A**: Núcleo consolidado + naming homogéneo + tests críticos.
- **Hito B**: Catálogo Forms/UI completo y consistente.
- **Hito C**: Motor de temas optimizado y escalable.
- **Hito D**: DX mejorada y onboarding simplificado.
- **Hito E**: Ciclo de release formalizado y sostenible.

## 9) Definición de éxito del roadmap

El roadmap se considera exitoso cuando el paquete:

- Mantiene una API estable y coherente para consumo en Laravel.
- Permite ampliar componentes y temas sin fricción significativa.
- Garantiza calidad con pruebas y releases repetibles.
- Se integra con facilidad en proyectos nuevos y existentes.
