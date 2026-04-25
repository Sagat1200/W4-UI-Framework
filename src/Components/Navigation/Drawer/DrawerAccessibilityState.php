<?php

namespace W4\UI\Framework\Components\Navigation\Drawer;

class DrawerAccessibilityState
{
    public function __construct(
        public string $role = 'dialog',
        public bool $ariaModal = true,
        public bool $ariaHidden = true,
        public ?string $ariaLabelledBy = null,
        public ?string $ariaLabel = null,
    ) {}

    public function toArray(): array
    {
        return [
            'role' => $this->role,
            'aria_modal' => $this->ariaModal,
            'aria_hidden' => $this->ariaHidden,
            'aria_labelledby' => $this->ariaLabelledBy,
            'aria_label' => $this->ariaLabel,
        ];
    }

    public function toAttributes(): array
    {
        $attributes = [
            'role' => $this->role,
            'aria-modal' => $this->ariaModal ? 'true' : 'false',
        ];

        if ($this->ariaHidden) {
            $attributes['aria-hidden'] = 'true';
        } else {
            $attributes['aria-hidden'] = 'false';
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
