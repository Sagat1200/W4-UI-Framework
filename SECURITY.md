# Security Policy

## Idioma

Este proyecto mantiene su política de seguridad en español para facilitar la comunicación con su equipo mantenedor.

## Versiones soportadas

Se considera con soporte de seguridad la versión estable más reciente del paquete y las versiones menores activas que no estén deprecadas.

Guía general:

- Última versión estable: soporte activo.
- Versiones en mantenimiento: soporte limitado a vulnerabilidades críticas.
- Versiones fuera de mantenimiento: sin parches de seguridad garantizados.

## Reportar una vulnerabilidad

Si detectas una vulnerabilidad, repórtala de forma privada por correo:

- `seguridad@w4.software`

Incluye, en lo posible:

- Descripción del problema.
- Impacto potencial.
- Pasos para reproducir.
- Versión(es) afectadas.
- Prueba de concepto mínima.
- Propuesta de mitigación, si aplica.

## Qué esperar tras el reporte

Proceso objetivo:

1. Confirmación de recepción.
2. Validación técnica del hallazgo.
3. Definición de severidad y alcance.
4. Preparación de fix y pruebas de regresión.
5. Publicación de parche y nota de seguridad.

El equipo prioriza reportes con riesgo de ejecución no autorizada, exposición de datos, inyección o bypass de controles.

## Política de divulgación responsable

- No divulgar públicamente la vulnerabilidad antes de que exista corrección o mitigación acordada.
- Se reconoce y agradece el reporte responsable.
- La divulgación pública se recomienda después del release del fix.

## Buenas prácticas para contribuidores

- No subir secretos, tokens o credenciales al repositorio.
- Evitar exponer datos sensibles en logs de depuración.
- Mantener dependencias actualizadas y revisar cambios de seguridad.
- Acompañar fixes sensibles con pruebas.

## Alcance técnico de seguridad

Este paquete se enfoca en abstracción de componentes UI para Laravel. El consumidor final debe:

- Configurar correctamente su aplicación host.
- Aplicar hardening de infraestructura y entorno.
- Gestionar permisos, autenticación y autorización fuera del alcance de este paquete.

## Coordinación de parches

Cuando una vulnerabilidad sea confirmada:

- Se prepara parche en versión compatible según SemVer.
- Se documenta impacto y recomendación de actualización.
- Se actualiza changelog con referencia de seguridad cuando corresponda.
