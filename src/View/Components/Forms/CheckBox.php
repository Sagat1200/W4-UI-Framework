<?php

namespace W4\UiFramework\View\Components\Forms;

use W4\UiFramework\Components\Forms\CheckBox\CheckBox as CheckBoxComponent;
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentEvent;
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxInteractState;
use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\View\Components\BaseW4BladeComponent;

class CheckBox extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public string $type = 'checkbox',
        public ?string $value = null,
        public ?string $helperText = null,
        public ?string $errorMessage = null,
        public string $variant = 'default',
        public string $size = 'md',
        public bool $checked = false,
        public bool $indeterminate = false,
        public bool $disabled = false,
        public bool $loading = false,
        public bool $readonly = false,
        public bool $invalid = false,
        public bool $valid = false,
        public bool $focused = false,
        public bool $hovered = false,
        public bool $pressed = false,
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
        $checkbox = CheckBoxComponent::make($this->label)
            ->type($this->type)
            ->variant($this->variant)
            ->size($this->size)
            ->checked($this->checked)
            ->indeterminate($this->indeterminate);

        if ($this->value !== null) {
            $checkbox->value($this->value);
        }

        if ($this->helperText !== null) {
            $checkbox->helperText($this->helperText);
        }

        if ($this->errorMessage !== null) {
            $checkbox->errorMessage($this->errorMessage);
        }

        if ($this->loading) {
            $checkbox->dispatch(CheckBoxComponentEvent::START_LOADING);
        } elseif ($this->disabled) {
            $checkbox->dispatch(CheckBoxComponentEvent::DISABLE);
        } elseif ($this->readonly) {
            $checkbox->dispatch(CheckBoxComponentEvent::SET_READONLY);
        } elseif ($this->invalid || $this->errorMessage) {
            $checkbox->dispatch(CheckBoxComponentEvent::SET_INVALID);
        } elseif ($this->valid) {
            $checkbox->dispatch(CheckBoxComponentEvent::SET_VALID);
        }

        $checkbox->interactState(new CheckBoxInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            pressed: $this->pressed,
        ));

        return $checkbox;
    }
}
