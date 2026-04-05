@php
    $theme = $theme ?? [];
    $data = $data ?? [];

    $classes = $theme['classes'] ?? [];
    $attrs = $theme['attributes'] ?? [];
    unset($attrs['class']);

    $rootClass = $classes['root'] ?? '';
    $codeClass = $classes['code'] ?? '';
    $hintClass = $classes['hint'] ?? '';

    $message = $data['message'] ?? $data['label'] ?? null;
    $code = $data['code'] ?? null;
    $hint = $data['hint'] ?? null;
@endphp

@if($message)
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
        @if($code)
            <span class="{{ $codeClass }}">{{ $code }}</span>
        @endif

        <span>{{ $message }}</span>

        @if($hint)
            <span class="{{ $hintClass }}">{{ $hint }}</span>
        @endif
    </div>
@endif
