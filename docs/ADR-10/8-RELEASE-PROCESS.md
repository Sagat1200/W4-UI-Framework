# RELEASE PROCESS — W4 UI FRAMEWORK

## 1) Objetivo

Definir un proceso de release repetible, trazable y seguro para `W4 UI Framework`, con foco en:

- Estabilidad de API pública.
- Calidad técnica verificable antes de publicar.
- Coherencia entre código, assets, pruebas y documentación.
- Comunicación clara de cambios a consumidores del paquete.

## 2) Alcance

Este proceso aplica a:

- Versiones del paquete PHP (`composer`).
- Assets CSS distribuidos por el paquete (`resources/dist` y build asociado).
- Publicación de cambios funcionales en componentes, temas, render y contratos.
- Actualización de documentación de producto y técnica.

## 3) Política de versionado (SemVer)

Se adopta versionado semántico:

- **MAJOR (X.0.0)**: cambios incompatibles con versiones anteriores.
- **MINOR (0.X.0)**: funcionalidades nuevas compatibles hacia atrás.
- **PATCH (0.0.X)**: correcciones sin cambio de comportamiento público esperado.

Reglas:

- No introducir breaking changes en `MINOR` o `PATCH`.
- Toda deprecación debe anunciarse antes de remover comportamiento.
- Cambios en payload, aliases, firmas públicas o contratos deben evaluarse como potencial MAJOR.

## 4) Tipos de release

- **Hotfix**:
  - Corrige fallo crítico.
  - Debe minimizar superficie de cambio.
  - Normalmente versión `PATCH`.

- **Feature release**:
  - Introduce componentes, props o mejoras de tema.
  - Debe incluir pruebas y documentación asociada.
  - Normalmente versión `MINOR`.

- **Major release**:
  - Incluye cambios incompatibles o rediseños de contrato.
  - Requiere guía de migración explícita.
  - Versión `MAJOR`.

## 5) Checklist pre-release

Antes de etiquetar una versión:

1. Confirmar alcance exacto del release (hotfix/feature/major).
2. Verificar que no haya cambios incompletos o experimentales.
3. Ejecutar pruebas del paquete:
   - `composer test`
4. Validar build de assets CSS:
   - `npm run build:css`
5. Verificar que salidas de build y manifest estén consistentes.
6. Revisar compatibilidad de configuración (`config/w4-ui-framework.php`).
7. Validar componentes clave en al menos:
   - un componente UI (`button`),
   - un componente Forms (`input` o `select`),
   - un tema alternativo (`daisyui` o `tailwind`).
8. Revisar cambios de documentación impactada (`README`, ADRs, guías).
9. Actualizar `CHANGELOG.md`.
10. Confirmar versión objetivo acorde a SemVer.

## 6) Criterios de calidad obligatorios

Un release solo puede avanzar si:

- Las pruebas pasan en su totalidad.
- No hay regresiones conocidas sin documentar.
- No existen errores críticos de render en componentes base.
- El payload mantiene estructura esperada para consumidores.
- La documentación no contradice comportamiento real.

## 7) Flujo de publicación recomendado

## Etapa A — Preparación

- Consolidar cambios aprobados.
- Actualizar versión en `composer.json` si la estrategia interna lo requiere.
- Actualizar `CHANGELOG.md` con formato claro:
  - Added
  - Changed
  - Fixed
  - Deprecated
  - Removed

## Etapa B — Verificación técnica

- Ejecutar pruebas de integración.
- Ejecutar build de assets.
- Validar manualmente escenarios de render representativos.
- Revisar diff final para detectar cambios accidentales.

## Etapa C — Corte de release

- Crear tag de versión (ejemplo: `v1.4.0`).
- Publicar release notes con:
  - resumen ejecutivo,
  - cambios relevantes,
  - riesgos/consideraciones,
  - instrucciones de actualización.

## Etapa D — Post-release

- Verificar instalación limpia en proyecto consumidor.
- Monitorear incidencias iniciales.
- Registrar lecciones aprendidas para el próximo ciclo.

## 8) Gestión de deprecaciones

Cuando se depreca una API:

- Marcar explícitamente en documentación y changelog.
- Mantener compatibilidad por al menos un ciclo razonable.
- Ofrecer alternativa equivalente y ejemplos de migración.
- Programar fecha o versión objetivo de remoción.

Regla:

- Nunca eliminar silenciosamente una API usada por consumidores.

## 9) Gestión de breaking changes

Si un cambio rompe compatibilidad:

- Clasificar release como MAJOR.
- Documentar impacto exacto (qué cambia y por qué).
- Incluir guía de migración paso a paso.
- Incluir ejemplos “antes / después”.
- Añadir pruebas que cubran nuevo contrato esperado.

## 10) Plantilla mínima de release notes

Cada release debe publicar:

- **Versión**: `vX.Y.Z`
- **Fecha**: `YYYY-MM-DD`
- **Resumen**: objetivo del release
- **Added**: nuevas capacidades
- **Changed**: cambios compatibles
- **Fixed**: correcciones
- **Deprecated**: APIs en salida gradual
- **Removed**: eliminaciones (solo si aplica)
- **Notas de migración**: acciones requeridas para consumidores
- **Riesgos conocidos**: limitaciones temporales

## 11) Matriz de verificación funcional mínima

Validar antes de publicar:

- Render por helper (`w4_render`) con tema por defecto.
- Render por facade (`W4Ui::render`) con tema explícito.
- Componente Blade con prefijo configurado.
- Estado de componente con efecto visual y atributos (`active`, `invalid`, etc.).
- Scope wrapper habilitado/deshabilitado según configuración.

## 12) Rollback y contingencia

Si se detecta fallo crítico post-release:

1. Evaluar severidad y alcance.
2. Comunicar incidencia de forma inmediata.
3. Definir estrategia:
   - rollback lógico (si distribución/plataforma lo permite),
   - hotfix PATCH urgente.
4. Publicar nota de incidente y resolución.
5. Incorporar prueba de regresión para evitar recurrencia.

## 13) Roles sugeridos en el proceso

- **Release owner**: coordina checklist y decisión de corte.
- **Reviewer técnico**: valida calidad de código, pruebas y contratos.
- **Responsable de documentación**: garantiza coherencia de changelog/guías.
- **Validador funcional**: confirma escenarios representativos de integración.

En equipos pequeños, una persona puede asumir varios roles, manteniendo explícita la responsabilidad.

## 14) Métricas de salud del release process

- Tasa de releases exitosos sin hotfix inmediato.
- Número de regresiones reportadas por versión.
- Tiempo de resolución de incidencias críticas.
- Cumplimiento del checklist pre-release.
- Porcentaje de cambios documentados correctamente.

## 15) Definición de release “listo”

Un release está listo para publicación cuando:

- Cumple checklist pre-release completo.
- Tiene versión y changelog consistentes.
- Pasa pruebas y build de assets.
- Mantiene compatibilidad esperada o documenta ruptura de forma explícita.
- Incluye release notes accionables para consumidores.
