# Support

## Idioma

La comunicación de soporte para este paquete se mantiene en español.

## Alcance de soporte

Este documento aplica al paquete `W4 UI Framework` y cubre:

- Dudas de instalación y configuración.
- Incidencias de uso en componentes, temas y render.
- Errores reproducibles en integración con Laravel.
- Consultas sobre comportamiento documentado del paquete.

No cubre:

- Soporte general de infraestructura del proyecto host.
- Desarrollo a medida fuera del alcance funcional del paquete.
- Incidencias de dependencias externas no relacionadas directamente.

## Canales de contacto

Para solicitudes de soporte técnico:

- `support@w4.software`

Para reportes de seguridad:

- `seguridad@w4.software`

## Información mínima para abrir un caso

Incluye, en lo posible:

- Versión del paquete (`w4/ui-framework`).
- Versión de PHP y Laravel.
- Tema y renderer utilizados.
- Código mínimo para reproducir.
- Resultado esperado vs resultado actual.
- Logs o trazas relevantes.

## Clasificación de solicitudes

- **Consulta funcional**: dudas de uso, configuración o API.
- **Bug**: comportamiento incorrecto reproducible.
- **Regresión**: funcionalidad que dejó de funcionar tras actualización.
- **Mejora**: propuesta de cambio compatible con el roadmap.

## Prioridad sugerida

- **Alta**: bloqueo de flujo crítico o fallo severo en producción.
- **Media**: fallo funcional con workaround disponible.
- **Baja**: consulta, mejora o ajuste menor sin impacto inmediato.

## Flujo de atención

1. Recepción del caso.
2. Revisión de información y reproducibilidad.
3. Clasificación (consulta, bug, regresión o mejora).
4. Definición de acción:
   - respuesta de uso,
   - fix,
   - inclusión en backlog.
5. Cierre con validación de resultado.

## Tiempos de respuesta

Los tiempos dependen de:

- Severidad del problema.
- Claridad del caso reportado.
- Disponibilidad de una reproducción mínima.

Regla práctica:

- Casos completos y reproducibles se atienden con mayor rapidez.

## Buenas prácticas para solicitar soporte

- Reportar un problema por caso, evitando mezclar incidencias.
- Adjuntar ejemplo mínimo ejecutable cuando sea posible.
- Indicar si el problema ocurre con `w4native`.
- Confirmar si el fallo persiste con configuración por defecto.

## Relación con documentación del proyecto

Antes de abrir un caso, se recomienda revisar:

- `README.md`
- `docs/ADR-10/*`
- `SECURITY.md` para incidentes de seguridad

## Cierre y seguimiento

Un caso se considera resuelto cuando:

- Existe respuesta técnica clara o parche publicado.
- Se valida que el resultado coincide con lo esperado.
- Queda trazabilidad del cambio en documentación/changelog cuando aplique.
