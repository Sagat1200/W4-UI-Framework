<?php

namespace W4\UI\Framework\Components\UI\Button;

class ButtonAccessibilityState
{
    public function __construct(
        public string $role = 'button',
        public string $ariaLive = 'off',
        public bool $ariaAtomic = true,
        public bool $ariaHidden = false,
        public bool $ariaBusy = false,
        public ?string $ariaPressed = 'false',
        public ?string $ariaDisabled = 'false',
        public ?string $ariaReadOnly = 'false',
        public ?string $ariaLabel = null,
        public ?string $ariaDescribedBy = null,
    ) {}

    public function toArray(): array
    {
        return [
            'role' => $this->role,
            'aria_live' => $this->ariaLive,
            'aria_atomic' => $this->ariaAtomic,
            'aria_hidden' => $this->ariaHidden,
            'aria_busy' => $this->ariaBusy,
            'aria_pressed' => $this->ariaPressed,
            'aria_disabled' => $this->ariaDisabled,
            'aria_readonly' => $this->ariaReadOnly,
            'aria_label' => $this->ariaLabel,
            'aria_describedby' => $this->ariaDescribedBy,
        ];
    }

    public function toAttributes(): array
    {
        $attributes = [
            'role' => $this->role,
            'aria-live' => $this->ariaLive,
            'aria-atomic' => $this->ariaAtomic ? 'true' : 'false',
            'aria-hidden' => $this->ariaHidden ? 'true' : 'false',
            'aria-busy' => $this->ariaBusy ? 'true' : 'false',
        ];

        if ($this->ariaPressed !== null) {
            $attributes['aria-pressed'] = $this->ariaPressed;
        }

        if ($this->ariaDisabled !== null) {
            $attributes['aria-disabled'] = $this->ariaDisabled;
        }

        if ($this->ariaReadOnly !== null) {
            $attributes['aria-readonly'] = $this->ariaReadOnly;
        }

        if ($this->ariaLabel !== null && $this->ariaLabel !== '') {
            $attributes['aria-label'] = $this->ariaLabel;
        }

        if ($this->ariaDescribedBy !== null && $this->ariaDescribedBy !== '') {
            $attributes['aria-describedby'] = $this->ariaDescribedBy;
        }

        return $attributes;
    }
}
