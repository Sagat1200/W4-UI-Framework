<?php

namespace W4\UiFramework\View\Components\Forms;

use W4\UiFramework\Components\Forms\Input\Input as InputComponent;
use W4\UiFramework\Components\Forms\Input\InputComponentState;
use W4\UiFramework\Components\Forms\Input\InputInteractState;
use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\View\Components\BaseW4BladeComponent;

class Input extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        public string $type = 'text',
        public ?string $value = null,
        public ?string $placeholder = null,
        public ?string $helperText = null,
        public ?string $errorMessage = null,
        public string $variant = 'default',
        public string $size = 'md',
        public bool $disabled = false,
        public bool $readonly = false,
    ) {
        parent::__construct(
            id: $id,
            name: $name,
            theme: $theme,
            renderer: $renderer,
        );
    }

    protected function makeComponent(): ComponentInterface
    {
        $input = InputComponent::make($this->label)
            ->type($this->type)
            ->variant($this->variant)
            ->size($this->size);

        if ($this->value !== null) {
            $input->value($this->value);
        }

        if ($this->placeholder !== null) {
            $input->placeholder($this->placeholder);
        }

        if ($this->helperText !== null) {
            $input->helperText($this->helperText);
        }

        if ($this->errorMessage !== null) {
            $input->errorMessage($this->errorMessage);
        }

        if ($this->readonly) {
            $input->state(InputComponentState::READONLY);
        } elseif ($this->disabled) {
            $input->state(InputComponentState::DISABLED);
        } elseif ($this->errorMessage) {
            $input->state(InputComponentState::INVALID);
        } else {
            $input->state(InputComponentState::ENABLED);
        }

        $input->interactState(new InputInteractState());

        return $input;
    }
}
