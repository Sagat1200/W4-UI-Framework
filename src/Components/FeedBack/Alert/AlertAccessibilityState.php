<?php

namespace W4\UI\Framework\Components\FeedBack\Alert;

class AlertAccessibilityState
{
    public function __construct(
        public string $role = 'alert',
        public string $ariaLive = 'assertive',
        public bool $ariaAtomic = true,
        public bool $ariaHidden = false,
        public bool $ariaBusy = false,
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

        if ($this->ariaLabel !== null && $this->ariaLabel !== '') {
            $attributes['aria-label'] = $this->ariaLabel;
        }

        if ($this->ariaDescribedBy !== null && $this->ariaDescribedBy !== '') {
            $attributes['aria-describedby'] = $this->ariaDescribedBy;
        }

        return $attributes;
    }
}
