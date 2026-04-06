<?php

namespace W4\UiFramework\Support;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\Core\RuntimeRenderer;

class W4UiManager
{
    public function __construct(
        protected RuntimeRenderer $runtimeRenderer,
        protected ViewFactory $viewFactory
    ) {}

    public function render(ComponentInterface $component, ?string $renderer = null): string
    {
        $payload = $this->runtimeRenderer->render($component, $renderer);

        if (! is_array($payload)) {
            return (string) $payload;
        }

        $this->logDebugPayloadIfEnabled($payload, $renderer, 'render');

        $viewName = $payload['view'] ?? null;

        if (! is_string($viewName) || $viewName === '') {
            return '';
        }

        return $this->viewFactory->make($viewName, [
            'data' => $payload['data'] ?? [],
            'theme' => $payload['theme'] ?? [],
            'component' => $component,
            'payload' => $payload,
        ])->render();
    }

    public function view(ComponentInterface $component, ?string $renderer = null): View|string
    {
        $payload = $this->runtimeRenderer->render($component, $renderer);

        if (! is_array($payload)) {
            return (string) $payload;
        }

        $this->logDebugPayloadIfEnabled($payload, $renderer, 'view');

        $viewName = $payload['view'] ?? null;

        if (! is_string($viewName) || $viewName === '') {
            return '';
        }

        return $this->viewFactory->make($viewName, [
            'data' => $payload['data'] ?? [],
            'theme' => $payload['theme'] ?? [],
            'component' => $component,
            'payload' => $payload,
        ]);
    }

    public function payload(ComponentInterface $component, ?string $renderer = null): mixed
    {
        $payload = $this->runtimeRenderer->render($component, $renderer);

        if (is_array($payload)) {
            $this->logDebugPayloadIfEnabled($payload, $renderer, 'payload');
        }

        return $payload;
    }

    protected function logDebugPayloadIfEnabled(array $payload, ?string $renderer = null, string $origin = 'payload'): void
    {
        if (! config('w4-ui-framework.w4_ui_log', false)) {
            return;
        }

        $data = $payload['data'] ?? [];
        $meta = is_array($data['meta'] ?? null) ? $data['meta'] : [];
        $attributes = is_array($data['attributes'] ?? null) ? $data['attributes'] : [];
        $componentId = $meta['component_id'] ?? null;
        $domComponentId = $attributes['data-component-id'] ?? null;

        if (($domComponentId === null || $domComponentId === '') && ($componentId === null || $componentId === '')) {
            return;
        }

        if ($domComponentId === null || $domComponentId === '') {
            $domComponentId = (string) $componentId;
        }

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/w4.ui.log'),
            'level' => 'debug',
        ])->debug('w4_ui.component_log', [
            'origin' => $origin,
            'renderer' => $payload['renderer'] ?? $renderer,
            'view' => $payload['view'] ?? null,
            'component' => $payload['component'] ?? ($data['component'] ?? null),
            'state' => $data['state'] ?? null,
            'component_id' => $componentId,
            'dom_component_id' => $domComponentId,
            'data' => $data,
            'theme' => $payload['theme'] ?? [],
        ]);
    }
}