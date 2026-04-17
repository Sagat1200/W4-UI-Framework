@php
    $classes = $theme['classes'] ?? [];
    $attrs = $theme['attributes'] ?? [];
    unset($attrs['class']);

    $rootClass = $classes['root'] ?? '';
    $text = $data['text'] ?? null;
    $label = $data['label'] ?? null;
    $content = $text ?? $label;
@endphp

<label
    class="{{ $rootClass }}"
    @foreach ($attrs as $attr => $value)
        @if (is_bool($value))
            @if ($value)
                {{ $attr }}
            @endif
        @elseif ($value !== null)
            {{ $attr }}="{{ e($value) }}"
        @endif
    @endforeach
>
    {{ $content }}
</label>
