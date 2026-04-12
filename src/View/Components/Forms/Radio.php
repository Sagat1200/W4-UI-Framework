<?php

namespace W4\UiFramework\View\Components\Forms;

use W4\UiFramework\Components\Forms\Radio\Radio as RadioComponent;
use W4\UiFramework\Components\Forms\Radio\RadioComponentEvent;
use W4\UiFramework\Components\Forms\Radio\RadioInteractState;
use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\View\Components\BaseW4BladeComponent;

class Radio extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public string $type = 'radio',
        public ?string $value = null,
        public ?string $group = null,
        public ?string $helperText = null,
        public ?string $errorMessage = null,
        public string $variant = 'default',
        public string $size = 'md',
        public bool $selected = false,
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
        $radio = RadioComponent::make($this->label)
            ->type($this->type)
            ->variant($this->variant)
            ->size($this->size)
            ->selected($this->selected);

        if ($this->value !== null) {
            $radio->value($this->value);
        }

        if ($this->group !== null) {
            $radio->group($this->group);
        }

        if ($this->helperText !== null) {
            $radio->helperText($this->helperText);
        }

        if ($this->errorMessage !== null) {
            $radio->errorMessage($this->errorMessage);
        }

        if ($this->loading) {
            $radio->dispatch(RadioComponentEvent::START_LOADING);
        } elseif ($this->disabled) {
            $radio->dispatch(RadioComponentEvent::DISABLE);
        } elseif ($this->readonly) {
            $radio->dispatch(RadioComponentEvent::SET_READONLY);
        } elseif ($this->invalid || $this->errorMessage) {
            $radio->dispatch(RadioComponentEvent::SET_INVALID);
        } elseif ($this->valid) {
            $radio->dispatch(RadioComponentEvent::SET_VALID);
        }

        $radio->interactState(new RadioInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            pressed: $this->pressed,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $radio->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $radio->accessibilityState($accessibilityState);
        }

        return $radio;
    }
}
