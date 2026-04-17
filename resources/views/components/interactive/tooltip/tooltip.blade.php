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
    $bubbleClass = $classes['bubble'] ?? '';

    $label = $data['label'] ?? null;
    $text = $data['text'] ?? null;
    $placement = $data['placement'] ?? 'top';
    $trigger = $data['trigger'] ?? 'hover';
    $delay = $data['delay'] ?? 0;
@endphp

<span
    @foreach($attrs as $attr => $value)
        @if(is_bool($value))
            @if($value) {{ $attr }} @endif
        @elseif($value !== null)
            {{ $attr }}="{{ e($value) }}"
        @endif
    @endforeach
    class="{{ $rootClass }}"
    data-w4-placement="{{ e($placement) }}"
    data-w4-trigger="{{ e($trigger) }}"
    data-w4-delay="{{ e($delay) }}"
>
    @if($label)
        <span>{{ $label }}</span>
    @endif

    @if($text)
        <span class="{{ $bubbleClass }}">{{ $text }}</span>
    @endif
</span>
