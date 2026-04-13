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
    $titleClass = $classes['title'] ?? '';
    $subtitleClass = $classes['subtitle'] ?? '';
    $contentClass = $classes['content'] ?? '';

    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $content = $data['content'] ?? null;
@endphp

<section
    @foreach($attrs as $attr => $value)
        @if(is_bool($value))
            @if($value) {{ $attr }} @endif
        @elseif($value !== null)
            {{ $attr }}="{{ e($value) }}"
        @endif
    @endforeach
    class="{{ $rootClass }}"
>
    @if($title)
        <header class="{{ $titleClass }}">{{ $title }}</header>
    @endif

    @if($subtitle)
        <div class="{{ $subtitleClass }}">{{ $subtitle }}</div>
    @endif

    @if($content)
        <div class="{{ $contentClass }}">{{ $content }}</div>
    @endif
</section>
