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
    $labelClass = $classes['label'] ?? '';

    $label = $data['label'] ?? null;
    $icon = $data['icon'] ?? null;
    $href = $data['href'] ?? null;
@endphp

@if($href)
    <a
        @foreach($attrs as $attr => $value)
            @if(is_bool($value))
                @if($value) {{ $attr }} @endif
            @elseif($value !== null)
                {{ $attr }}="{{ e($value) }}"
            @endif
        @endforeach
        href="{{ $href }}"
        class="{{ $rootClass }}"
    >
        @if($icon)
            <span class="{{ $iconClass }}">{{ $icon }}</span>
        @endif
        <span class="{{ $labelClass }}">{{ $label }}</span>
    </a>
@else
    <button
        type="button"
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
        <span class="{{ $labelClass }}">{{ $label }}</span>
    </button>
@endif
