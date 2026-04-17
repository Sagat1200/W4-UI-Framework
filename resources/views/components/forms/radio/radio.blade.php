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
    $inputClass = $classes['input'] ?? '';
    $labelClass = $classes['label'] ?? '';
    $textClass = $classes['text'] ?? '';
    $helperClass = $classes['helper'] ?? '';
    $errorClass = $classes['error'] ?? '';

    $label = $data['label'] ?? null;
    $helperText = $data['helper_text'] ?? null;
    $errorMessage = $data['error_message'] ?? null;
    $hasId = ($attrs['id'] ?? $data['id'] ?? null) !== null;
@endphp

<div class="{{ $rootClass }}">
    <label
        @if($hasId) for="{{ $attrs['id'] ?? $data['id'] }}" @endif
        class="{{ $labelClass }}"
    >
        <input
            @foreach($attrs as $attr => $value)
                @if(is_bool($value))
                    @if($value) {{ $attr }} @endif
                @elseif($value !== null)
                    {{ $attr }}="{{ e($value) }}"
                @endif
            @endforeach
            class="{{ $inputClass }}"
        >

        @if($label)
            <span class="{{ $textClass }}">{{ $label }}</span>
        @endif
    </label>

    @if($helperText && ! $errorMessage)
        <small class="{{ $helperClass }}">{{ $helperText }}</small>
    @endif

    @if($errorMessage)
        <small class="{{ $errorClass }}">{{ $errorMessage }}</small>
    @endif
</div>
