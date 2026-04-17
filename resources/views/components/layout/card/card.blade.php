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
    $bodyClass = $classes['body'] ?? '';
    $footerClass = $classes['footer'] ?? '';

    $title = $data['title'] ?? null;
    $subtitle = $data['subtitle'] ?? null;
    $body = $data['body'] ?? null;
    $footer = $data['footer'] ?? null;
@endphp

<article
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

    @if($body)
        <section class="{{ $bodyClass }}">{{ $body }}</section>
    @endif

    @if($footer)
        <footer class="{{ $footerClass }}">{{ $footer }}</footer>
    @endif
</article>
