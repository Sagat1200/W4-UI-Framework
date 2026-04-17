<?php

namespace W4\UI\Framework\View\Components\Forms\Toggle;

use W4\UI\Framework\Components\Forms\Toggle\Toggle as ToggleComponent;
use W4\UI\Framework\Components\Forms\Toggle\ToggleComponentEvent;
use W4\UI\Framework\Components\Forms\Toggle\ToggleInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Toggle extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $value = null,
        public ?string $helperText = null,
        public ?string $errorMessage = null,
        public string $variant = 'default',
        public string $size = 'md',
        public bool $checked = false,
        public bool $disabled = false,
        public bool $loading = false,
        public bool $readonly = false,
        public bool $invalid = false,
        public bool $valid = false,
        public bool $focused = false,
        public bool $hovered = false,
        public bool $pressed = false,
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
        $toggle = ToggleComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->checked($this->checked);

        if ($this->value !== null) {
            $toggle->value($this->value);
        }

        if ($this->helperText !== null) {
            $toggle->helperText($this->helperText);
        }

        if ($this->errorMessage !== null) {
            $toggle->errorMessage($this->errorMessage);
        }

        if ($this->loading) {
            $toggle->dispatch(ToggleComponentEvent::START_LOADING);
        } elseif ($this->disabled) {
            $toggle->dispatch(ToggleComponentEvent::DISABLE);
        } elseif ($this->readonly) {
            $toggle->dispatch(ToggleComponentEvent::SET_READONLY);
        } elseif ($this->invalid || $this->errorMessage) {
            $toggle->dispatch(ToggleComponentEvent::SET_INVALID);
        } elseif ($this->valid) {
            $toggle->dispatch(ToggleComponentEvent::SET_VALID);
        }

        $toggle->interactState(new ToggleInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            pressed: $this->pressed,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $toggle->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $toggle->accessibilityState($accessibilityState);
        }

        return $toggle;
    }
}
