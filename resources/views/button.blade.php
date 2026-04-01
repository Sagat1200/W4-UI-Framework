@php
    $classes = $theme['classes']['root'] ?? '';
    $attrs = $theme['attributes'] ?? [];
@endphp

<button
    id="{{ $data['id'] }}"
    class="{{ $classes }}"
    @foreach ($attrs as $attr => $value)
        @if (is_bool($value))
            @if ($value)
                {{ $attr }}
            @endif
        @else
            {{ $attr }}="{{ $value }}"
        @endif
    @endforeach
>
    {{ $data['label'] }}
</button>
