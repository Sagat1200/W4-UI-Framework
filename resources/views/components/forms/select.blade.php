@php
    $theme = $theme ?? [];
    $data = $data ?? [];

    $classes = $theme['classes'] ?? [];
    $attrs = $theme['attributes'] ?? [];
    unset($attrs['class']);

    $rootClass = $classes['root'] ?? '';
    $inputClass = $classes['input'] ?? '';
    $labelClass = $classes['label'] ?? '';
    $helperClass = $classes['helper'] ?? '';
    $errorClass = $classes['error'] ?? '';

    $label = $data['label'] ?? null;
    $helperText = $data['helper_text'] ?? null;
    $errorMessage = $data['error_message'] ?? null;
    $placeholder = $data['placeholder'] ?? null;
    $options = $data['options'] ?? [];
    $selectedValue = $data['selected'] ?? null;
    $isMultiple = (bool) ($attrs['multiple'] ?? false);
    $selectedValues = is_array($selectedValue)
        ? array_map('strval', $selectedValue)
        : ($selectedValue === null ? [] : [(string) $selectedValue]);
    $hasId = ($attrs['id'] ?? $data['id'] ?? null) !== null;
@endphp

<div class="{{ $rootClass }}">
    @if($label)
        <label
            @if($hasId) for="{{ $attrs['id'] ?? $data['id'] }}" @endif
            class="{{ $labelClass }}"
        >
            {{ $label }}
        </label>
    @endif

    <select
        @foreach($attrs as $attr => $value)
            @if(is_bool($value))
                @if($value) {{ $attr }} @endif
            @elseif($value !== null)
                {{ $attr }}="{{ e($value) }}"
            @endif
        @endforeach
        class="{{ $inputClass }}"
    >
        @if($placeholder && ! $isMultiple)
            <option value="" @if(count($selectedValues) === 0) selected @endif disabled>
                {{ $placeholder }}
            </option>
        @endif

        @foreach($options as $optionValue => $optionLabel)
            @php $isSelected = in_array((string) $optionValue, $selectedValues, true); @endphp
            <option value="{{ e((string) $optionValue) }}" @if($isSelected) selected @endif>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @if($helperText && ! $errorMessage)
        <small class="{{ $helperClass }}">{{ $helperText }}</small>
    @endif

    @if($errorMessage)
        <small class="{{ $errorClass }}">{{ $errorMessage }}</small>
    @endif
</div>
