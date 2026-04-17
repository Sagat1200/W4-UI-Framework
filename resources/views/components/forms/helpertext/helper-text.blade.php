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
    $iconClass = $classes['icon'] ?? '';
    $textClass = $classes['text'] ?? '';

    $text = $data['text'] ?? $data['label'] ?? null;
    $icon = $data['icon'] ?? null;
@endphp

@if($text)
    <small
        @foreach($attrs as $attr => $value)
            @if(is_bool($value))
                @if($value) {{ $attr }} @endif
            @elseif($value !== null)
                {{ $attr }}="{{ e($value) }}"
            @endif
        @endforeach
        class="{{ $rootClass }}"
    >
        @if($icon)
            <span class="{{ $iconClass }}">{{ $icon }}</span>
        @endif

        <span class="{{ $textClass }}">{{ $text }}</span>
    </small>
@endif
