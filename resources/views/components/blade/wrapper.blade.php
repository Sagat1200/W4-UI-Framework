@php
    $instance = $component();

    $extraAttributes = $attributes->getAttributes();

    $componentId = $extraAttributes['componentId']
        ?? $extraAttributes['component-id']
        ?? null;

    if ($componentId !== null && method_exists($instance, 'meta')) {
        $instance->meta('component_id', $componentId);
    }

    if ($componentId !== null && method_exists($instance, 'attribute')) {
        $instance->attribute('data-component-id', (string) $componentId);
    }

    unset($extraAttributes['componentId'], $extraAttributes['component-id']);

    if (method_exists($instance, 'attributes') && !empty($extraAttributes)) {
        $instance->attributes($extraAttributes);
    }
@endphp
{{-- {!! $html() !!} --}}

{!! app(\W4\UI\Framework\Support\W4UiManager::class)->render($instance, $renderer) !!}