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
    $messageClass = $classes['message'] ?? '';
    $iconClass = $classes['icon'] ?? '';
    $dismissClass = $classes['dismiss'] ?? '';

    $title = $data['title'] ?? null;
    $message = $data['message'] ?? null;
    $icon = $data['icon'] ?? null;
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
    @if($icon)
        <span class="{{ $iconClass }}">{{ $icon }}</span>
    @endif

    <div>
        @if($title)
            <div class="{{ $titleClass }}">{{ $title }}</div>
        @endif

        @if($message)
            <div class="{{ $messageClass }}">{{ $message }}</div>
        @endif
    </div>

    @if($dismissible)
        <button
            type="button"
            class="{{ $dismissClass }}"
            data-w4-dismiss="alert"
            aria-label="Dismiss"
        >
            ×
        </button>
    @endif
</div>
