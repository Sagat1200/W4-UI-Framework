<?php

use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\Support\W4UiManager;

if (! function_exists('w4_render')) {
    function w4_render(ComponentInterface $component, ?string $renderer = null): string
    {
        return app(W4UiManager::class)->render($component, $renderer);
    }
}

if (! function_exists('w4_view')) {
    function w4_view(ComponentInterface $component, ?string $renderer = null)
    {
        return app(W4UiManager::class)->view($component, $renderer);
    }
}

if (! function_exists('w4_payload')) {
    function w4_payload(ComponentInterface $component, ?string $renderer = null): mixed
    {
        return app(W4UiManager::class)->payload($component, $renderer);
    }
}

if (! function_exists('w4_debug_payload')) {
    function w4_debug_payload(ComponentInterface $component, ?string $renderer = null): array
    {
        $payload = app(W4UiManager::class)->payload($component, $renderer);

        if (! is_array($payload)) {
            return [
                'renderer' => $renderer,
                'view' => null,
                'component' => null,
                'state' => null,
                'component_id' => null,
                'dom_component_id' => null,
                'payload' => $payload,
            ];
        }

        $data = $payload['data'] ?? [];
        $meta = is_array($data['meta'] ?? null) ? $data['meta'] : [];
        $attributes = is_array($data['attributes'] ?? null) ? $data['attributes'] : [];

        return [
            'renderer' => $payload['renderer'] ?? $renderer,
            'view' => $payload['view'] ?? null,
            'component' => $payload['component'] ?? ($data['component'] ?? null),
            'state' => $data['state'] ?? null,
            'component_id' => $meta['component_id'] ?? null,
            'dom_component_id' => $attributes['data-component-id'] ?? null,
            'payload' => $payload,
        ];
    }
}
