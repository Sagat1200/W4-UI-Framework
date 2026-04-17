@php
    $classes = $theme['classes'] ?? [];
    $attrs = $theme['attributes'] ?? [];
    unset($attrs['class']);

    $rootClass = $classes['root'] ?? '';
    $iconToken = trim((string) ($data['icon'] ?? $data['label'] ?? ''));
    $iconClass = trim($rootClass . ' ' . $iconToken);
@endphp

<i
    class="{{ $iconClass }}"
    @foreach ($attrs as $attr => $value)
        @if (is_bool($value))
            @if ($value)
                {{ $attr }}
            @endif
        @elseif ($value !== null)
            {{ $attr }}="{{ e($value) }}"
        @endif
    @endforeach
></i>
