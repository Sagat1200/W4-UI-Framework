<?php

namespace W4\UiFramework\Components\Forms\CheckBox;

use InvalidArgumentException;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class CheckBox extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $type = 'checkbox';

    protected ?string $value = null;

    protected bool $checked = false;

    protected bool $indeterminate = false;

    protected ?string $helperText = null;

    protected ?string $errorMessage = null;

    protected CheckBoxInteractState $interactState;

    protected CheckBoxStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = CheckBoxComponentState::ENABLED;
        $this->interactState = new CheckBoxInteractState();
        $this->stateMachine = new CheckBoxStateMachine();
    }

    public function componentName(): string
    {
        return 'checkbox';
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

    public function checked(?bool $checked = null): bool|static
    {
        if ($checked === null) {
            return $this->checked;
        }

        $this->checked = $checked;

        if ($checked) {
            $this->indeterminate = false;
        }

        return $this;
    }

    public function indeterminate(?bool $indeterminate = null): bool|static
    {
        if ($indeterminate === null) {
            return $this->indeterminate;
        }

        $this->indeterminate = $indeterminate;

        if ($indeterminate) {
            $this->checked = false;
        }

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

    public function interactState(?CheckBoxInteractState $state = null): CheckBoxInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(CheckBoxComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(CheckBoxComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function check(): static
    {
        $this->dispatch(CheckBoxComponentEvent::CHECK);
        $this->checked(true);
        $this->indeterminate(false);

        return $this;
    }

    public function uncheck(): static
    {
        $this->dispatch(CheckBoxComponentEvent::UNCHECK);
        $this->checked(false);
        $this->indeterminate(false);

        return $this;
    }

    public function toggle(): static
    {
        $this->dispatch(CheckBoxComponentEvent::TOGGLE);

        if ($this->indeterminate()) {
            $this->checked(true);
            $this->indeterminate(false);

            return $this;
        }

        $this->checked(! $this->checked());

        return $this;
    }

    public function setIndeterminate(): static
    {
        $this->dispatch(CheckBoxComponentEvent::SET_INDETERMINATE);
        $this->indeterminate(true);
        $this->checked(false);

        return $this;
    }

    public function clearIndeterminate(): static
    {
        $this->dispatch(CheckBoxComponentEvent::CLEAR_INDETERMINATE);
        $this->indeterminate(false);

        return $this;
    }

    public function disable(): static
    {
        return $this->dispatch(CheckBoxComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(CheckBoxComponentEvent::ENABLE);
    }

    public function setReadonly(): static
    {
        return $this->dispatch(CheckBoxComponentEvent::SET_READONLY);
    }

    public function setInvalid(): static
    {
        return $this->dispatch(CheckBoxComponentEvent::SET_INVALID);
    }

    public function setValid(): static
    {
        return $this->dispatch(CheckBoxComponentEvent::SET_VALID);
    }

    public function startLoading(): static
    {
        return $this->dispatch(CheckBoxComponentEvent::START_LOADING);
    }

    public function finishLoading(): static
    {
        return $this->dispatch(CheckBoxComponentEvent::FINISH_LOADING);
    }

    public function resetState(): static
    {
        $this->dispatch(CheckBoxComponentEvent::RESET);
        $this->checked(false);
        $this->indeterminate(false);

        return $this;
    }

    protected function currentState(): CheckBoxComponentState
    {
        if ($this->state instanceof CheckBoxComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return CheckBoxComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de checkbox inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del checkbox no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'type' => $this->type(),
            'value' => $this->value(),
            'checked' => $this->checked(),
            'indeterminate' => $this->indeterminate(),
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
            'checked' => $this->checked(),
            'indeterminate' => $this->indeterminate(),
            'helper_text' => $this->helperText(),
            'error_message' => $this->errorMessage(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}