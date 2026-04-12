@php
    $classes = $theme['classes'] ?? [];
    $attrs = $theme['attributes'] ?? [];
    unset($attrs['class']);

    $rootClass = $classes['root'] ?? '';
    $labelClass = $classes['label'] ?? '';

    $text = $data['text'] ?? null;
    $label = $data['label'] ?? null;
    $content = $text ?? $label;
@endphp

<div
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
    @if($content)
        <span class="{{ $labelClass }}">{{ $content }}</span>
    @endif
</div>
