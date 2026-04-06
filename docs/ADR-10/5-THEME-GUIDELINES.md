# THEME GUIDELINES — W4 UI FRAMEWORK

## 1) Objetivo

Establecer lineamientos para diseñar, implementar y mantener temas en `W4 UI Framework`, asegurando:

- Consistencia visual y funcional entre componentes.
- Paridad de comportamiento entre temas soportados.
- Separación clara entre lógica de componente y lógica de estilo.
- Escalabilidad para incorporar nuevos temas sin deuda técnica innecesaria.

## 2) Alcance

Estas guías aplican a:

- `src/Themes/Bootstrap/**`
- `src/Themes/DaisyUI/**`
- `src/Themes/Tailwind/**`
- `ThemeManager`, `ThemeResolverPipeline` y contratos relacionados.
- Assets CSS de soporte en `resources/assets/css/**`.

## 3) Principios de diseño de temas

- **Theme as adapter**: el tema adapta estilos/atributos, no reglas de negocio.
- **Paridad primero**: componentes equivalentes deben resolver estructura equivalente de salida.
- **Estado explícito**: estilos deben variar por estado de componente de forma declarativa.
- **Sin side-effects**: un resolver de tema no debe escribir logs, tocar IO ni mutar estado externo.
- **Extensión predecible**: agregar un tema nuevo debe seguir plantilla y convenciones conocidas.

## 4) Estructura estándar de un tema

Cada tema debe incluir:

- Clase raíz de tema (`BootstrapTheme`, `DaisyTheme`, `TailwindTheme`).
- Resolves por dominio:
  - `Components/Forms/*ThemeResolver.php`
  - `Components/UI/*ThemeResolver.php`

Regla: cada componente soportado en el framework debe tener resolver por tema activo.

## 5) Contrato de salida del resolver

El resultado de un `ThemeResolver` debe ser determinístico y compatible con el pipeline de render.

Estructura mínima recomendada:

- `classes`: mapa de clases por slot (`root`, `label`, `icon`, etc.).
- `attributes`: atributos HTML/ARIA por estado.

Reglas:

- Nunca retornar `null` en estructuras críticas cuando se espera arreglo.
- Mantener keys estables para evitar condicionales frágiles en vistas Blade.
- Priorizar composición de clases legibles y predecibles.

## 6) Paridad entre temas

Se considera paridad cuando, para un mismo componente y estado:

- Se respeta la misma intención visual/semántica.
- Se exponen atributos de accesibilidad equivalentes.
- El payload conserva estructura y slots compatibles.

Mínimo exigido por componente:

- Estado base.
- Un estado interactivo relevante (`active`, `loading`, `invalid`, etc.).
- Variantes principales (por ejemplo `primary`, `secondary`) cuando aplique.
- Tamaños soportados (`sm`, `md`, `lg`) cuando aplique.

## 7) Reglas de clases CSS

- Evitar clases hardcodeadas en vistas Blade cuando deban depender del tema.
- Centralizar decisiones de clases en el resolver del tema.
- Reutilizar patrones de composición (base + variante + estado + tamaño).
- Evitar concatenaciones opacas; preferir bloques claramente separables.

Para frameworks utilitarios:

- Tailwind/DaisyUI: mantener clases agrupadas por intención.
- Bootstrap: priorizar utilidades y clases del sistema oficial antes de customizaciones.

## 8) Reglas de atributos y A11y

Cada resolver debe complementar clases con atributos semánticos cuando el estado lo requiera:

- `aria-invalid` para campos inválidos.
- `aria-disabled` para controles deshabilitados.
- `aria-pressed` para controles toggleables/activos.
- `role` cuando el elemento lo necesite para semántica accesible.

Regla: no depender solo de clases visuales para exponer estado.

## 9) Integración con scoping CSS

Cuando el proyecto use scope (`w4_ui_scope_enabled`), los temas deben:

- Ser compatibles con wrappers de scope por tema.
- Evitar selectors excesivamente globales.
- Mantener safelists alineadas a clases realmente emitidas por resolvers.

Buenas prácticas:

- Revisar `resources/assets/css/*/*/*safelist.css`.
- Mantener sincronía entre resolvers y build de CSS.
- Evitar introducir clases que no estén contempladas en el proceso de build.

## 10) Onboarding de un tema nuevo

Checklist mínimo:

1. Crear clase de tema en `src/Themes/<Tema>/<Tema>Theme.php`.
2. Crear resolvers para `UI` y `Forms` con paridad base.
3. Registrar tema en `ThemeManager` vía Service Provider.
4. Añadir assets/safelist necesarios para build CSS.
5. Verificar render con componentes representativos (`button`, `input`, `select`, etc.).
6. Agregar pruebas de integración del tema.
7. Documentar capacidades y límites del tema.

## 11) Reglas de compatibilidad y evolución

- No alterar abruptamente nombres de slots en `classes`.
- Evitar eliminar atributos esperados por vistas existentes.
- Si se ajusta semántica de salida:
  - documentar cambio,
  - validar impacto en componentes Blade,
  - cubrir con pruebas de regresión.

Estrategia recomendada:

- Cambios mayores solo bajo versión mayor.
- Cambios menores compatibles bajo versión menor/parche.

## 12) Testing mínimo por tema

Cada tema debe contar con pruebas que validen:

- Resolución de clases para componente base.
- Resolución de atributos para estado alterado.
- Compatibilidad de payload en render completo.
- Registro correcto en manager/pipeline.
- Cobertura mínima en al menos:
  - un componente UI,
  - un componente Forms.

## 13) Errores comunes a evitar

- Duplicar lógica de estado en resolvers y en vistas.
- Introducir diferencias arbitrarias de API entre temas.
- Agregar clases no contempladas en build/safelist.
- Acoplar resolver a detalles internos de implementación de Blade.
- Resolver atributos sin considerar accesibilidad.

## 14) Definición de listo (DoD) para un tema

Un tema se considera listo cuando:

- Resuelve componentes base de `UI` y `Forms` con paridad funcional.
- Mantiene estructura de salida estable (`classes` + `attributes`).
- Soporta estados principales con accesibilidad básica.
- Está registrado y disponible vía configuración global y por componente.
- Tiene pruebas de integración y documentación alineadas.
