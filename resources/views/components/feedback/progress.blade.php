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
    $labelClass = $classes['label'] ?? '';

    $label = $data['label'] ?? null;
    $value = $data['value'] ?? 0;
    $min = $data['min'] ?? 0;
    $max = $data['max'] ?? 100;
    $indeterminate = (bool) ($data['indeterminate'] ?? false);
@endphp

<div>
    @if($label)
        <div class="{{ $labelClass }}">{{ $label }}</div>
    @endif

    <progress
        @foreach($attrs as $attr => $valueAttr)
            @if(is_bool($valueAttr))
                @if($valueAttr) {{ $attr }} @endif
            @elseif($valueAttr !== null)
                {{ $attr }}="{{ e($valueAttr) }}"
            @endif
        @endforeach
        class="{{ $rootClass }}"
        max="{{ e($max) }}"
        @if(!$indeterminate)value="{{ e($value) }}"@endif
        min="{{ e($min) }}"
    ></progress>
</div>
