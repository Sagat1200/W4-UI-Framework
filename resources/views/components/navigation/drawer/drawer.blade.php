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
    $overlayClass = $classes['overlay'] ?? '';
    $panelClass = $classes['panel'] ?? '';
    $headerClass = $classes['header'] ?? '';
    $bodyClass = $classes['body'] ?? '';
    $footerClass = $classes['footer'] ?? '';

    $position = $data['position'] ?? 'right';
    $isOpen = $data['open'] ?? false;
    $hasOverlay = $data['overlay'] ?? true;
@endphp

<div class="{{ $rootClass }} {{ $isOpen ? 'is-open' : '' }} position-{{ $position }}">
    @if($hasOverlay)
        <div class="{{ $overlayClass }}" aria-hidden="true"></div>
    @endif

    <div @foreach($attrs as $attr => $value) @if(is_bool($value)) @if($value) {{ $attr }} @endif @elseif($value !== null)
    {{ $attr }}="{{ e($value) }}" @endif @endforeach class="{{ $panelClass }}">
        @if(isset($header))
            <div class="{{ $headerClass }}">
                {{ $header }}
            </div>
        @endif

        <div class="{{ $bodyClass }}">
            {{ $slot }}
        </div>

        @if(isset($footer))
            <div class="{{ $footerClass }}">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>