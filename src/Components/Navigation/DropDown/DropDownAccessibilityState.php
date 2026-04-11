<?php

namespace W4\UiFramework\Components\Navigation\DropDown;

class DropDownAccessibilityState
{
    public function __construct(
        public string $role = 'menu',
        public string $ariaLive = 'off',
        public bool $ariaAtomic = true,
        public bool $ariaHidden = false,
        public bool $ariaBusy = false,
        public bool $ariaExpanded = false,
        public string $ariaHasPopup = 'menu',
        public ?string $ariaControls = null,
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
            'aria_expanded' => $this->ariaExpanded,
            'aria_haspopup' => $this->ariaHasPopup,
            'aria_controls' => $this->ariaControls,
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
            'aria-expanded' => $this->ariaExpanded ? 'true' : 'false',
            'aria-haspopup' => $this->ariaHasPopup,
        ];

        if ($this->ariaControls !== null && $this->ariaControls !== '') {
            $attributes['aria-controls'] = $this->ariaControls;
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
