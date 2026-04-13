@php
    $theme = $theme ?? [];
    $data = $data ?? [];

    $classes = $theme['classes'] ?? [];
    $attrs = $theme['attributes'] ?? [];
    $componentAttrs = is_array($data['attributes'] ?? null) ? $data['attributes'] : [];
    $accessibilityAttrs = is_array($data['accessibility_attributes'] ?? null) ? $data['accessibility_attributes'] : [];
    $attrs = array_merge($attrs, $componentAttrs, $accessibilityAttrs);
    unset($attrs['class']);

    $rootClass = $classes['root'] ?? '';
    $indicatorClass = $classes['indicator'] ?? '';
    $messageClass = $classes['message'] ?? '';

    $label = $data['label'] ?? null;
    $message = $data['message'] ?? null;
    $type = $data['type'] ?? 'spinner';
@endphp

<div
    @foreach($attrs as $attr => $value)
        @if(is_bool($value))
            @if($value) {{ $attr }} @endif
        @elseif($value !== null)
            {{ $attr }}="{{ e($value) }}"
        @endif
    @endforeach
    class="{{ $rootClass }}"
>
    <span
        class="{{ $indicatorClass }}"
        data-w4-loading-type="{{ e($type) }}"
        aria-hidden="true"
    ></span>

    @if($message)
        <span class="{{ $messageClass }}">{{ $message }}</span>
    @elseif($label)
        <span class="{{ $messageClass }}">{{ $label }}</span>
    @endif
</div>
