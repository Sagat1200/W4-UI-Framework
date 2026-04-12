<?php

namespace W4\UI\Framework\Components\Forms\Input;

use InvalidArgumentException;
use W4\UI\Framework\Components\Forms\Input\InputAccessibilityState;
use W4\UI\Framework\Components\Forms\Input\InputComponentEvent;
use W4\UI\Framework\Components\Forms\Input\InputComponentState;
use W4\UI\Framework\Components\Forms\Input\InputInteractState;
use W4\UI\Framework\Components\Forms\Input\InputStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

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
    protected InputAccessibilityState $accessibilityState;
    protected InputStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = InputComponentState::ENABLED;
        $this->interactState = new InputInteractState();
        $this->accessibilityState = new InputAccessibilityState();
        $this->stateMachine = new InputStateMachine();
        $this->syncAccessibilityState();
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

    public function accessibilityState(?InputAccessibilityState $state = null): InputAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(InputComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(InputComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function disable(): static
    {
        return $this->dispatch(InputComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(InputComponentEvent::ENABLE);
    }

    public function setReadonly(): static
    {
        return $this->dispatch(InputComponentEvent::SET_READONLY);
    }

    public function setInvalid(): static
    {
        return $this->dispatch(InputComponentEvent::SET_INVALID);
    }

    public function setValid(): static
    {
        return $this->dispatch(InputComponentEvent::SET_VALID);
    }

    public function startLoading(): static
    {
        return $this->dispatch(InputComponentEvent::START_LOADING);
    }

    public function finishLoading(): static
    {
        return $this->dispatch(InputComponentEvent::FINISH_LOADING);
    }

    public function resetState(): static
    {
        return $this->dispatch(InputComponentEvent::RESET);
    }

    protected function currentState(): InputComponentState
    {
        if ($this->state instanceof InputComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return InputComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de input inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del input no es válido.');
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
            'accessibility_state' => $this->accessibilityState()->toArray(),
            'accessibility_attributes' => $this->accessibilityState()->toAttributes(),
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
            'accessibility_state' => $this->accessibilityState()->toArray(),
            'accessibility_attributes' => $this->accessibilityState()->toAttributes(),
        ]);
    }

    protected function syncAccessibilityState(): void
    {
        $stateValue = (string) $this->stateValue();

        $this->accessibilityState->ariaHidden = $stateValue === InputComponentState::DISABLED->value;
        $this->accessibilityState->ariaBusy = $stateValue === InputComponentState::LOADING->value;
        $this->accessibilityState->ariaInvalid = $stateValue === InputComponentState::INVALID->value;
        $this->accessibilityState->ariaReadonly = $stateValue === InputComponentState::READONLY->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
