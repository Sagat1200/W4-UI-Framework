@php
    $instance = $component();

    $extraAttributes = $attributes->getAttributes();

    if (method_exists($instance, 'attributes') && !empty($extraAttributes)) {
        $instance->attributes($extraAttributes);
    }
@endphp
{{-- {!! $html() !!} --}}

{!! app(\W4\UiFramework\Support\W4UiManager::class)->render($instance, $renderer) !!}