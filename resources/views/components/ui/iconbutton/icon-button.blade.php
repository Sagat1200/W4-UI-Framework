@php
    $classes = $theme['classes']['root'] ?? '';
    $attrs = $theme['attributes'] ?? [];
    unset($attrs['class']);

    $iconToken = trim((string) ($data['icon'] ?? ''));
    $label = trim((string) ($data['label'] ?? ''));
@endphp

<button
    id="{{ $data['id'] }}"
    class="{{ $classes }}"
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
    @if ($iconToken !== '')
        <i class="{{ $iconToken }}" aria-hidden="true"></i>
    @endif

    @if ($label !== '')
        <span class="visually-hidden sr-only">{{ $label }}</span>
    @endif
</button>
