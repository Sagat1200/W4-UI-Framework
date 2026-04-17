<?php

namespace W4\UI\Framework\Components\Navigation\Tab\TabPane;

class TabPaneAccessibilityState
{
    public function __construct(
        public string $role = 'tabpanel',
        public bool $ariaHidden = false,
        public ?string $ariaLabelledBy = null,
        public ?string $ariaLabel = null,
    ) {}

    public function toArray(): array
    {
        return [
            'role' => $this->role,
            'aria_hidden' => $this->ariaHidden,
            'aria_labelledby' => $this->ariaLabelledBy,
            'aria_label' => $this->ariaLabel,
        ];
    }

    public function toAttributes(): array
    {
        $attributes = [
            'role' => $this->role,
        ];

        if ($this->ariaHidden) {
            $attributes['aria-hidden'] = 'true';
        }

        if ($this->ariaLabelledBy !== null && $this->ariaLabelledBy !== '') {
            $attributes['aria-labelledby'] = $this->ariaLabelledBy;
        }

        if ($this->ariaLabel !== null && $this->ariaLabel !== '') {
            $attributes['aria-label'] = $this->ariaLabel;
        }

        return $attributes;
    }
}
