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
    $listClass = $classes['list'] ?? '';
    $itemClass = $classes['item'] ?? '';
    $separatorClass = $classes['separator'] ?? '';
    $linkClass = $classes['link'] ?? '';
    $currentClass = $classes['current'] ?? '';

    $items = is_array($data['items'] ?? null) ? $data['items'] : [];
    $separator = $data['separator'] ?? '/';
    $homeLabel = $data['home_label'] ?? null;
    $homeUrl = $data['home_url'] ?? null;
@endphp

<nav
    @foreach($attrs as $attr => $value)
        @if(is_bool($value))
            @if($value) {{ $attr }} @endif
        @elseif($value !== null)
            {{ $attr }}="{{ e($value) }}"
        @endif
    @endforeach
    class="{{ $rootClass }}"
>
    <ol class="{{ $listClass }}">
        @if($homeLabel)
            <li class="{{ $itemClass }}">
                @if($homeUrl)
                    <a href="{{ $homeUrl }}" class="{{ $linkClass }}">{{ $homeLabel }}</a>
                @else
                    <span class="{{ $currentClass }}">{{ $homeLabel }}</span>
                @endif
            </li>
        @endif

        @foreach($items as $index => $item)
            <li class="{{ $separatorClass }}">{{ $separator }}</li>
            <li class="{{ $itemClass }}">
                @php
                    $itemLabel = is_array($item) ? ($item['label'] ?? null) : (is_string($item) ? $item : null);
                    $itemUrl = is_array($item) ? ($item['url'] ?? null) : null;
                    $isCurrent = is_array($item) ? (bool) ($item['current'] ?? false) : false;
                @endphp
                @if($itemUrl && ! $isCurrent)
                    <a href="{{ $itemUrl }}" class="{{ $linkClass }}">{{ $itemLabel }}</a>
                @else
                    <span class="{{ $currentClass }}">{{ $itemLabel }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
