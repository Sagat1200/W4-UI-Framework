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
    $bodyClass = $classes['body'] ?? '';
    $footerClass = $classes['footer'] ?? '';

    $title = $data['title'] ?? null;
    $body = $data['body'] ?? null;
    $footer = $data['footer'] ?? null;
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

    @if($body)
        <div class="{{ $bodyClass }}">{{ $body }}</div>
    @endif

    @if($footer)
        <footer class="{{ $footerClass }}">{{ $footer }}</footer>
    @endif
</section>
