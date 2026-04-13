<?php

namespace W4\UI\Framework\Components\FeedBack\Progress;

class ProgressAccessibilityState
{
    public function __construct(
        public string $role = 'progressbar',
        public string $ariaLive = 'polite',
        public bool $ariaAtomic = true,
        public bool $ariaHidden = false,
        public bool $ariaBusy = false,
        public ?string $ariaValueNow = '0',
        public ?string $ariaValueMin = '0',
        public ?string $ariaValueMax = '100',
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
            'aria_valuenow' => $this->ariaValueNow,
            'aria_valuemin' => $this->ariaValueMin,
            'aria_valuemax' => $this->ariaValueMax,
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

        if ($this->ariaValueNow !== null) {
            $attributes['aria-valuenow'] = $this->ariaValueNow;
        }

        if ($this->ariaValueMin !== null) {
            $attributes['aria-valuemin'] = $this->ariaValueMin;
        }

        if ($this->ariaValueMax !== null) {
            $attributes['aria-valuemax'] = $this->ariaValueMax;
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
