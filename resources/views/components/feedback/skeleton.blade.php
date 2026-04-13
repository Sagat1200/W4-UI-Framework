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

    $lines = max(1, (int) ($data['lines'] ?? 1));
    $width = $data['width'] ?? null;
    $height = $data['height'] ?? null;
@endphp

<div>
    @for($i = 0; $i < $lines; $i++)
        <span @foreach($attrs as $attr => $value) @if(is_bool($value)) @if($value) {{ $attr }} @endif @elseif($value !== null)
        {{ $attr }}="{{ e($value) }}" @endif @endforeach class="{{ $rootClass }}" @if($width !== null)
            style="inline-size: {{ e($width) }}; @if($height !== null) block-size: {{ e($height) }}; @endif" @elseif($height !== null) style="block-size: {{ e($height) }};" @endif></span>
    @endfor
</div>