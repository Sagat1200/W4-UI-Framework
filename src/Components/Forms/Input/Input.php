<?php

namespace W4\UiFramework\Components\Forms\Input;

use W4\UiFramework\Components\Forms\Input\InputComponentState;
use W4\UiFramework\Components\Forms\Input\InputInteractState;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Input extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $type = 'text';

    protected ?string $value = null;

    protected ?string $placeholder = null;

    protected ?string $helperText = null;

    protected ?string $errorMessage = null;

    protected InputInteractState $interactState;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = InputComponentState::ENABLED;
        $this->interactState = new InputInteractState();
    }

    public function componentName(): string
    {
        return 'input';
    }

    public function type(?string $type = null): string|static|null
    {
        if ($type === null) {
            return $this->type;
        }

        $this->type = $type;

        return $this;
    }

    public function value(?string $value = null): string|static|null
    {
        if ($value === null) {
            return $this->value;
        }

        $this->value = $value;

        return $this;
    }

    public function placeholder(?string $placeholder = null): string|static|null
    {
        if ($placeholder === null) {
            return $this->placeholder;
        }

        $this->placeholder = $placeholder;

        return $this;
    }

    public function helperText(?string $helperText = null): string|static|null
    {
        if ($helperText === null) {
            return $this->helperText;
        }

        $this->helperText = $helperText;

        return $this;
    }

    public function errorMessage(?string $errorMessage = null): string|static|null
    {
        if ($errorMessage === null) {
            return $this->errorMessage;
        }

        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function interactState(?InputInteractState $state = null): InputInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'type' => $this->type(),
            'value' => $this->value(),
            'placeholder' => $this->placeholder(),
            'helper_text' => $this->helperText(),
            'error_message' => $this->errorMessage(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'type' => $this->type(),
            'value' => $this->value(),
            'placeholder' => $this->placeholder(),
            'helper_text' => $this->helperText(),
            'error_message' => $this->errorMessage(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
