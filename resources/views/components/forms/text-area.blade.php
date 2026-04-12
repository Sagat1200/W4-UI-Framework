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
    $helperClass = $classes['helper'] ?? '';
    $errorClass = $classes['error'] ?? '';

    $label = $data['label'] ?? null;
    $helperText = $data['helper_text'] ?? null;
    $errorMessage = $data['error_message'] ?? null;
    $value = $data['value'] ?? '';
    $hasId = ($attrs['id'] ?? $data['id'] ?? null) !== null;
@endphp

<div class="{{ $rootClass }}">
    @if($label)
        <label @if($hasId) for="{{ $attrs['id'] ?? $data['id'] }}" @endif class="{{ $labelClass }}">
            {{ $label }}
        </label>
    @endif

    <textarea @foreach($attrs as $attr => $valueAttr) @if(is_bool($valueAttr)) @if($valueAttr) {{ $attr }} @endif
    @elseif($valueAttr !== null) {{ $attr }}="{{ e($valueAttr) }}" @endif @endforeach
        class="{{ $inputClass }}">{{ $value }}</textarea>

    @if($helperText && !$errorMessage)
        <small class="{{ $helperClass }}">{{ $helperText }}</small>
    @endif

    @if($errorMessage)
        <small class="{{ $errorClass }}">{{ $errorMessage }}</small>
    @endif
</div>