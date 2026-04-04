@php
    $classes = $theme['classes'] ?? [];
    $attrs = $theme['attributes'] ?? [];
    unset($attrs['class']);

    $rootClass = $classes['root'] ?? '';
    $level = strtolower((string) ($data['level'] ?? 'h2'));
    $allowedLevels = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
    $tag = in_array($level, $allowedLevels, true) ? $level : 'h2';

    $text = $data['text'] ?? null;
    $label = $data['label'] ?? null;
    $content = $text ?? $label;
@endphp

<{{ $tag }}
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
</{{ $tag }}>
