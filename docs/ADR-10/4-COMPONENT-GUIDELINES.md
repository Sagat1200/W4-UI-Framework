# COMPONENT GUIDELINES — W4 UI FRAMEWORK

## 1) Objetivo

Definir reglas de diseño, implementación y mantenimiento para componentes del paquete `W4 UI Framework`, asegurando:

- Consistencia de API entre componentes `UI` y `Forms`.
- Compatibilidad multi-tema (`bootstrap`, `daisyui`, `tailwind`).
- Integración limpia con renderizado Blade y helpers (`w4_render`, `w4_view`, `w4_payload`).
- Escalabilidad para nuevos componentes sin romper contratos existentes.

## 2) Alcance

Estas guías aplican a:

- Componentes de dominio en `src/Components/**`.
- Componentes Blade en `src/View/Components/**`.
- Vistas Blade en `resources/views/components/**`.
- Resolvers de tema en `src/Themes/**/Components/**`.
- Estado, eventos e interacción por componente.

## 3) Estructura estándar de un componente

Cada componente de dominio debe mantener la estructura base:

- `<Componente>.php`
- `<Componente>ComponentEvent.php`
- `<Componente>ComponentState.php`
- `<Componente>InteractState.php`
- `<Componente>StateMachine.php`

Ejemplos actuales:

- `src/Components/UI/Button/*`
- `src/Components/Forms/Input/*`

Regla: si un componente usa máquina de estados, debe exponer los cinco artefactos de forma homogénea.

## 4) Convenciones de naming

- El nombre de clase debe reflejar dominio y tipo (`Button`, `Input`, `FieldError`).
- El alias de registro debe ser kebab-case (`button`, `icon-button`, `field-error`).
- Los nombres de vistas deben seguir kebab-case y jerarquía por módulo:
  - `components/ui/button.blade.php`
  - `components/forms/input.blade.php`
- Los eventos deben usar verbos/intención (`SET_ACTIVE`, `START_LOADING`, `SET_INVALID`).
- Evitar variantes ortográficas inconsistentes en carpetas, namespaces y clases.

## 5) API mínima esperada en componentes

Todo componente debe:

- Implementar el contrato de componente usado por el core.
- Exponer método estático `make(...)` cuando aplique al patrón existente.
- Soportar metadatos/atributos comunes para render:
  - `id`, `class`, `attributes`,
  - `theme`,
  - `state` o mecanismos equivalentes.
- Mantener defaults razonables para no forzar configuración explícita en casos comunes.

## 6) Estado e interacción

- El estado del componente debe modelarse mediante enum/constantes de estado y eventos explícitos.
- La transición de estados debe estar centralizada en `StateMachine`.
- `InteractState` debe ser la capa que mapea intención de uso hacia eventos válidos.
- No mezclar reglas de transición con lógica de vista Blade.
- Eventos inválidos para un estado deben manejarse de forma predecible y segura.

## 7) Reglas para componentes Blade

Para cada componente de dominio visible en Blade, debe existir su wrapper en `src/View/Components`.

El wrapper debe:

- Recibir props públicas simples y predecibles.
- Traducir props de estado (`active`, `disabled`, `invalid`, etc.) a eventos de state machine.
- Construir el componente de dominio sin lógica de tema acoplada.
- Delegar render final al manager/pipeline del framework.

Regla: el componente Blade es adaptador de entrada, no motor de estilo ni de negocio.

## 8) Reglas para vistas Blade

Cada vista en `resources/views/components/**` debe:

- Consumir únicamente `data`, `theme`, `component` y `payload` esperados por el render.
- Evitar lógica condicional compleja que deba residir en el componente o resolver.
- Aplicar clases y atributos provenientes del tema, no hardcodearlos salvo estructura base mínima.
- Mantener markup semántico y accesible.

## 9) Reglas para ThemeResolvers

Todo resolver de tema debe:

- Resolver `classes` y `attributes` por componente y estado.
- Mantener parity funcional entre temas para componentes equivalentes.
- Evitar duplicación innecesaria; reutilizar patrones y convenciones.
- No introducir side-effects fuera de la resolución de estilos/atributos.

Salida recomendada mínima:

- `classes` (por slots, por ejemplo `root`, `icon`, `label`).
- `attributes` (por ejemplo `aria-*`, `role`, flags de estado).

## 10) Accesibilidad (A11y)

Requisitos base:

- Asociar `label` con controles de formulario cuando aplique.
- Exponer `aria-invalid`, `aria-pressed`, `aria-disabled` según estado real.
- Conservar navegabilidad por teclado para controles interactivos.
- No depender únicamente de color para comunicar estado.

Cada nuevo componente debe declarar su criterio mínimo de accesibilidad en su documentación.

## 11) Contratos y compatibilidad

- No romper contratos públicos sin estrategia de deprecación.
- Mantener compatibilidad de firmas públicas (`make`, setters principales, payload esperado).
- Si se requiere cambio incompatible:
  - marcar deprecación,
  - documentar migración,
  - cubrir con tests de regresión.

## 12) Testing mínimo por componente

Cada componente nuevo o modificado debe cubrir, al menos:

- Construcción/instanciación.
- Registro y resolución por alias (si aplica).
- Transiciones de estado principales.
- Resolución de tema por al menos un estado base y uno alterado.
- Render/payload con estructura esperada.
- Integración Blade básica (si existe wrapper Blade).

## 13) Checklist de incorporación de componente nuevo

1. Crear estructura completa en `src/Components`.
2. Registrar alias en `ComponentRegistry` (vía provider).
3. Crear resolver por tema soportado.
4. Crear wrapper Blade en `src/View/Components`.
5. Crear vista Blade en `resources/views/components`.
6. Añadir pruebas de integración y casos de estado.
7. Documentar uso y variantes.

## 14) Errores comunes a evitar

- Definir estilos directamente en componente de dominio.
- Duplicar reglas de estado entre `InteractState` y vista.
- Agregar props Blade sin mapearlas al componente base.
- Crear componente en un tema pero omitir paridad mínima en otros.
- Introducir naming inconsistente entre clase, archivo, alias y vista.

## 15) Definición de listo (DoD) para componentes

Un componente se considera listo cuando:

- Cumple estructura y naming estándar del framework.
- Tiene soporte funcional en los temas objetivo.
- Tiene wrapper y vista Blade consistentes.
- Pasa pruebas de integración relevantes.
- Tiene documentación de uso y estados alineada al comportamiento real.
