<?php

namespace W4\UiFramework\View\Components\Forms;

use W4\UiFramework\Components\Forms\HelperText\HelperText as HelperTextComponent;
use W4\UiFramework\Components\Forms\HelperText\HelperTextComponentEvent;
use W4\UiFramework\Components\Forms\HelperText\HelperTextInteractState;
use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\View\Components\BaseW4BladeComponent;

class HelperText extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $text = null,
        public ?string $forField = null,
        public ?string $icon = null,
        public string $variant = 'neutral',
        public string $size = 'sm',
        public bool $active = false,
        public bool $disabled = false,
        public bool $hidden = false,
        public bool $focused = false,
        public bool $hovered = false,
        public ?string $ariaLabel = null,
        public ?string $ariaDescribedBy = null,
    ) {
        parent::__construct(
            id: $id,
            name: $name,
            theme: $theme,
            renderer: $renderer,
            componentId: $componentId,
        );
    }

    protected function makeComponent(): ComponentInterface
    {
        $baseLabel = $this->label ?? $this->text;

        $helperText = HelperTextComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size);

        if ($this->text !== null) {
            $helperText->text($this->text);
        } elseif ($this->label !== null) {
            $helperText->text($this->label);
        }

        if ($this->forField !== null) {
            $helperText->forField($this->forField);
        }

        if ($this->icon !== null) {
            $helperText->icon($this->icon);
        }

        if ($this->hidden) {
            $helperText->dispatch(HelperTextComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $helperText->dispatch(HelperTextComponentEvent::DISABLE);
        } elseif ($this->active) {
            $helperText->dispatch(HelperTextComponentEvent::ACTIVATE);
        }

        $helperText->interactState(new HelperTextInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $helperText->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $helperText->accessibilityState($accessibilityState);
        }

        return $helperText;
    }
}
