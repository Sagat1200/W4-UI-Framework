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
    $triggerClass = $classes['trigger'] ?? '';
    $menuClass = $classes['menu'] ?? '';
    $itemClass = $classes['item'] ?? '';

    $label = $data['label'] ?? null;
    $items = is_array($data['items'] ?? null) ? $data['items'] : [];
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
    @if($label)
        <button type="button" class="{{ $triggerClass }}">{{ $label }}</button>
    @endif

    <ul class="{{ $menuClass }}">
        @foreach($items as $item)
            @php
                $itemLabel = is_array($item) ? ($item['label'] ?? null) : (is_string($item) ? $item : null);
                $itemUrl = is_array($item) ? ($item['url'] ?? null) : null;
            @endphp
            <li class="{{ $itemClass }}">
                @if($itemUrl)
                    <a href="{{ $itemUrl }}">{{ $itemLabel }}</a>
                @else
                    <span>{{ $itemLabel }}</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>
