<?php

/*
 * Configuración de W4-Ui-Framework:
 */

return [
    /*
     * Selección de tema:
     * Puedes seleccionar entre:
     * - bootstrap
     * - bootswatch
     * - tailwind
     * - daisyui
     */
    'theme' => env('W4_UI_THEME', 'bootstrap'),

    /*
     * Selección de render:
     * Puedes seleccionar entre:
     * - blade
     * - livewire
     * - inertia-react
     * - inertia-vue
     * - inertia-svelte
     * - all (para proyectos con multiples renderers).
     * 
     * Por defcto es blade
     * Nota: Para utilizar livewire y derivados de inertia, se debe de tenerlos instalados
     * y tener habilitados los paquetes puente w4-ui-livewire-bridge o los derivados de w4-ui-inertia-bridge.
     */
    'renderer' => env('W4_UI_RENDERER', 'blade'),

    /*
     * Configuración de paquetes puente:
     */
    'packages_w4_ui_bridge' => [
        'w4-ui-livewire-bridge' => [
            'enabled' => false,
        ],
        'w4-ui-inertia-react-bridge' => [
            'enabled' => false,
        ],
        'w4-ui-inertia-vue-bridge' => [
            'enabled' => false,
        ],
        'w4-ui-inertia-svelte-bridge' => [
            'enabled' => false,
        ],
    ],

    /*
     * Configuración de registro en archivo w4.ui.log:
     * Habilita registro en todos los componentes.
     * Nota: No se debe de utilizar en entorno de producción.
     */
    'w4_ui_log' => env('W4_UI_LOG', false),

    /*
     * Configuración de ámbito de componentes:
     * Habilita ámbito de componentes en todos los componentes.
     * Nota: No se debe de utilizar en entorno de producción.
     */
    'w4_ui_scope_enabled' => env('W4_UI_SCOPE_ENABLED', true),
    'w4_ui_scope_class' => env('W4_UI_SCOPE_CLASS', 'w4-scope'),

    /*
     * Configuración de prefijo de componentes:
     * Por defecto es w4
     * Usted puede cambiarlo si desea utilizar un prefijo diferente.
     */
    'w4_ui_component_prefix' => 'w4',
];
