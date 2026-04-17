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
    $brandClass = $classes['brand'] ?? '';
    $menuClass = $classes['menu'] ?? '';
    $itemClass = $classes['item'] ?? '';
    $linkClass = $classes['link'] ?? '';

    $brand = $data['brand'] ?? null;
    $brandUrl = $data['brand_url'] ?? null;
    $items = is_array($data['items'] ?? null) ? $data['items'] : [];
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
    @if($brand)
        <div class="{{ $brandClass }}">
            @if($brandUrl)
                <a href="{{ $brandUrl }}" class="{{ $linkClass }}">{{ $brand }}</a>
            @else
                <span class="{{ $linkClass }}">{{ $brand }}</span>
            @endif
        </div>
    @endif

    <ul class="{{ $menuClass }}">
        @foreach($items as $item)
            @php
                $itemLabel = is_array($item) ? ($item['label'] ?? null) : (is_string($item) ? $item : null);
                $itemUrl = is_array($item) ? ($item['url'] ?? null) : null;
            @endphp
            <li class="{{ $itemClass }}">
                @if($itemUrl)
                    <a href="{{ $itemUrl }}" class="{{ $linkClass }}">{{ $itemLabel }}</a>
                @else
                    <span class="{{ $linkClass }}">{{ $itemLabel }}</span>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
