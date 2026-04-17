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
    $dialogClass = $classes['dialog'] ?? '';
    $titleClass = $classes['title'] ?? '';
    $contentClass = $classes['content'] ?? '';
    $footerClass = $classes['footer'] ?? '';
    $closeClass = $classes['close'] ?? '';

    $title = $data['title'] ?? null;
    $content = $data['content'] ?? null;
    $footer = $data['footer'] ?? null;
    $dismissible = (bool) ($data['dismissible'] ?? false);
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
    <div class="{{ $dialogClass }}">
        @if($dismissible)
            <button
                type="button"
                class="{{ $closeClass }}"
                data-w4-dismiss="modal"
                aria-label="Close"
            >
                ×
            </button>
        @endif

        @if($title)
            <div class="{{ $titleClass }}">{{ $title }}</div>
        @endif

        @if($content)
            <div class="{{ $contentClass }}">{{ $content }}</div>
        @endif

        @if($footer)
            <div class="{{ $footerClass }}">{{ $footer }}</div>
        @endif
    </div>
</div>
