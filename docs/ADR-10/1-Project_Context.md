# 🚀 W4-UI-Framework

## ✨ Contexto del Proyecto

## 1. 📌 Información General

* **Nombre:** W4-UI-Framework
* **Tipo:** Paquete Composer para Laravel
* **Propósito:** Construir un motor universal de componentes UI para Laravel que permita:

  * definir componentes una sola vez en PHP
  * renderizarlos a través de distintos sistemas visuales
  * soportar múltiples renderizadores de frontend
  * habilitar personalización visual por tenant, usuario, panel o solicitud
  * servir como base UI para el ecosistema W4

## 2. 🧠 Planteamiento del Problema

Los proyectos modernos de Laravel suelen mezclar varios enfoques de UI:

* Blade
* Livewire
* Inertia
* React
* Vue
* Bootstrap
* Bootswatch
* Tailwind
* DaisyUI
* otros kits de UI

En la mayoría de los proyectos, los componentes de UI terminan fuertemente acoplados a:

* un framework CSS específico
* una estrategia de renderizado específica
* un stack frontend específico

Esto provoca problemas recurrentes:

* componentes duplicados para cada stack
* dificultad para cambiar temas o sistemas visuales
* baja consistencia entre paquetes
* soporte deficiente para branding multi-tenant en SaaS
* deuda técnica creciente al agregar nuevas tecnologías UI

## 3. 💡 Solución Propuesta

W4-UI-Framework introducirá una capa de abstracción de UI donde:

* los componentes se definen en PHP
* la salida visual se resuelve mediante un Theme Engine
* el renderizado es gestionado por un sistema de Renderer
* las integraciones específicas de cada renderer se delegan a paquetes bridge

Un componente como:

```php
Button::make('Guardar')
    ->variant('primary')
    ->size('lg');
```

debería poder renderizarse de forma consistente en los stacks soportados sin cambiar la definición del componente.

## 4. 🎯 Objetivos Principales

1. Crear un sistema universal de componentes para Laravel.
2. Soportar múltiples familias visuales, inicialmente:

   * Bootstrap
   * Bootswatch
   * DaisyUI
3. Soportar múltiples estrategias de renderizado:

   * Blade
   * Livewire
   * Inertia React
   * Inertia Vue
4. Mantener los componentes independientes de cualquier framework CSS concreto.
5. Permitir selección dinámica de tema y overrides visuales.
6. Mantener la arquitectura extensible para futuros bridges y paquetes.
7. Servir como base UI para el ecosistema W4.

## 5. 🧬 Ecosistema W4 Relacionado

Este paquete está pensado para convertirse en la base visual de:

* **W4-PowerTable**
* **W4-DynamicFormBuilder**
* **W4-FileUploadManager**
* **W4-NeuronTenant**
* **W4-NeuronStorage**

El objetivo a largo plazo es que todos estos paquetes compartan:

* el mismo modelo de componentes
* el mismo sistema de temas
* las mismas convenciones de estado
* las mismas reglas de identidad visual

## 6. 🏛️ Estado Actual del Proyecto

El proyecto **ya no está en etapa inicial**. El core está implementado y operativo para Laravel.

Estado actual confirmado:

* paquete Composer funcional (`w4/ui-framework`)
* contratos, gestores, pipelines y renderer base implementados
* componentes reales en producción dentro del paquete
* wrappers Blade funcionales con prefijo configurable
* suite de pruebas de integración activa

Tecnologías base del paquete actual:

* PHP `^8.3`
* Laravel `^13.0`
* Orchestra Testbench para pruebas del paquete

## 7. 🧱 Estado de Paquetes del Ecosistema

### 7.1 `w4/ui-framework` (actual)

Implementado con:

* Core de componentes (factory, registry, managers, pipelines)
* Renderizado por Blade
* Themes: Bootstrap y DaisyUI registrados en el manager
* Resolvers Tailwind implementados a nivel de componentes
* Helpers globales (`w4_render`, `w4_view`, `w4_payload`, `w4_debug_payload`)
* Facade `W4Ui`

### 7.2 `w4/inertia-bridge` (pendiente)

Sigue como objetivo del roadmap. Aún no está integrado en este repositorio.

### 7.3 `w4/livewire-bridge` (pendiente)

Sigue como objetivo del roadmap. Aún no está integrado en este repositorio.

## 8. 🧭 Arquitectura del Core Validada

El flujo arquitectónico definido sí quedó implementado:

```text
Componente PHP
   ↓
ThemeResolverPipeline
   ↓
RendererPipeline
   ↓
W4UiManager (render/view/payload)
   ↓
Salida Blade
```

Principios que hoy se cumplen:

* componentes desacoplados de clases CSS hardcodeadas
* resolución visual delegada a theme resolvers
* soporte de atributos y metadatos por componente
* extensibilidad por registro de componentes, themes y renderers

## 9. 🧩 Modelo de Componentes Implementado

Componentes implementados en el core:

* `Button`
* `Input`

Cada componente mantiene la convención:

* `{Component}ComponentEvent`
* `{Component}ComponentState`
* `{Component}InteractState`
* `{Component}StateMachine`

Capacidades actuales del modelo:

* estado y transición por eventos (`dispatch`)
* atributos arbitrarios (`attribute`, `attributes`)
* metadatos (`meta`)
* identidad (`id`, `name`)
* auditoría por `componentId` → `meta.component_id` y `data-component-id`

## 10. 🎨 Estado de Temas

Estado real de implementación:

* **Bootstrap:** implementado y registrado
* **DaisyUI:** implementado y registrado
* **Tailwind:** resolvers implementados para Button/Input, con documentación y pruebas unitarias de resolución; su uso global depende del registro en `ThemeManager`
* **Bootswatch:** no implementado aún en este repositorio

Responsabilidades cubiertas por los resolvers actuales:

* clases por variante
* clases por tamaño
* atributos por estado
* integración de clases custom del usuario (`class`)
* reglas de merge para evitar conflictos (`w-*`, `h-*`, `min/max-h`)

## 11. 🖥️ Estado de Renderers

Renderer actualmente operativo en el core:

* **Blade**

Capacidades Blade actuales:

* selección de vista por componente
* detección dinámica de subcarpetas en `resources/views/components/*` (excepto `blade`)
* wrappers Blade para renderizado declarativo
* payload normalizado para inspección y bridges futuros

Renderers pendientes por bridge:

* Livewire
* Inertia (React/Vue/Svelte)

## 12. ⚙️ Configuración y Publicación

Archivo de configuración vigente:

* `config/w4-ui-framework.php`

Claves activas relevantes:

* `theme`
* `renderer`
* `packages_w4_ui_bridge.*.enabled`
* `w4_ui_log`
* `w4_ui_component_prefix`

Publicaciones soportadas:

* `--tag=w4-ui-config` para publicar config
* `--tag=w4-ui-log` para publicar `storage/logs/w4.ui.log`

## 13. 🗂️ Estructura Real del Core

La estructura esperada ya está materializada y extendida:

```text
src/
├── Components
│   ├── UI/Button/*
│   └── Forms/Input/*
├── Contracts
├── Core
├── Facades
├── Helpers
├── Managers
├── Providers
├── Renderers
├── Support
├── Themes
│   ├── Bootstrap/*
│   ├── DaisyUI/*
│   └── Tailwind/*
└── View/Components
```

## 14. ✅ Hitos ya Completados

* definición e implementación del core base
* registro de componentes por factory/registry
* renderer Blade funcional
* themes Bootstrap y DaisyUI operativos
* componente `Button` completo con estado/eventos
* componente `Input` completo con estado/eventos
* wrappers Blade (`x-<prefix>-render`, `x-<prefix>-button`, `x-<prefix>-input`)
* helper de inspección `w4_debug_payload`
* logging dedicado de componentes en `w4.ui.log`
* pruebas de integración del provider, render, prefijos, payload y logging

## 15. 🧪 Alcance Vigente (v actual)

Alcance real del paquete en este momento:

* core usable en proyectos Laravel
* render por helper, facade y Blade component
* soporte de auditoría por `componentId`
* documentación técnica de componentes Daisy y Tailwind
* pruebas automatizadas pasando en CI/local (`composer test`)

## 16. 🚧 Pendientes Técnicos Reales

Pendientes principales de roadmap:

* integrar bridges Livewire e Inertia
* formalizar registro global de Tailwind en `ThemeManager`
* ampliar catálogo de componentes (más allá de Button/Input)
* ampliar cobertura de pruebas para escenarios cross-renderer

Riesgos a controlar:

* desalineación entre documentación y registro real de themes/renderers
* crecimiento de variaciones visuales sin reglas unificadas de merge de clases

## 17. 🏆 Visión de Largo Plazo (vigente)

Se mantiene la visión original:

* definir componentes una sola vez en PHP
* renderizarlos en múltiples renderers
* cambiar sistema visual sin reescribir componentes
* habilitar consistencia visual para el ecosistema W4
* soportar escenarios multi-tenant con configuración dinámica

## 18. 📍 Resumen Ejecutivo del Estado Actual

Estado real hoy:

* **core implementado y funcional**
* **Blade operativo como renderer principal**
* **Button e Input listos con state machine**
* **Bootstrap y DaisyUI estables**
* **Tailwind avanzado en resolvers, pendiente cierre de integración global**
* **bridges Livewire/Inertia aún pendientes**

## 19. ⏭️ Siguientes Pasos Concretos

Orden recomendado inmediato:

1. Registrar de forma oficial Tailwind en `ThemeManager` y validar flujo end-to-end.
2. Definir y arrancar el primer bridge (Livewire o Inertia) con contrato mínimo.
3. Expandir el set de componentes core reutilizando convenciones actuales.
4. Mantener pruebas de integración por cada nueva capacidad para evitar regresiones.

