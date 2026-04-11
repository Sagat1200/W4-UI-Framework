<?php

namespace W4\UiFramework\Components\Forms\Radio;

use InvalidArgumentException;
use W4\UiFramework\Components\Forms\Radio\RadioAccessibilityState;
use W4\UiFramework\Components\Forms\Radio\RadioComponentEvent;
use W4\UiFramework\Components\Forms\Radio\RadioComponentState;
use W4\UiFramework\Components\Forms\Radio\RadioInteractState;
use W4\UiFramework\Components\Forms\Radio\RadioStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Radio extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $type = 'radio';

    protected ?string $value = null;

    protected ?string $group = null;

    protected bool $selected = false;

    protected ?string $helperText = null;

    protected ?string $errorMessage = null;

    protected RadioInteractState $interactState;

    protected RadioAccessibilityState $accessibilityState;

    protected RadioStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = RadioComponentState::ENABLED;
        $this->interactState = new RadioInteractState();
        $this->accessibilityState = new RadioAccessibilityState();
        $this->stateMachine = new RadioStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'radio';
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

    public function group(?string $group = null): string|static|null
    {
        if ($group === null) {
            return $this->group;
        }

        $this->group = $group;

        return $this;
    }

    public function selected(?bool $selected = null): bool|static
    {
        if ($selected === null) {
            return $this->selected;
        }

        $this->selected = $selected;
        $this->syncAccessibilityState();

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

    public function interactState(?RadioInteractState $state = null): RadioInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?RadioAccessibilityState $state = null): RadioAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(RadioComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(RadioComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function select(): static
    {
        $this->dispatch(RadioComponentEvent::SELECT);
        $this->selected(true);

        return $this;
    }

    public function clear(): static
    {
        $this->dispatch(RadioComponentEvent::CLEAR);
        $this->selected(false);

        return $this;
    }

    public function disable(): static
    {
        return $this->dispatch(RadioComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(RadioComponentEvent::ENABLE);
    }

    public function setReadonly(): static
    {
        return $this->dispatch(RadioComponentEvent::SET_READONLY);
    }

    public function setInvalid(): static
    {
        return $this->dispatch(RadioComponentEvent::SET_INVALID);
    }

    public function setValid(): static
    {
        return $this->dispatch(RadioComponentEvent::SET_VALID);
    }

    public function startLoading(): static
    {
        return $this->dispatch(RadioComponentEvent::START_LOADING);
    }

    public function finishLoading(): static
    {
        return $this->dispatch(RadioComponentEvent::FINISH_LOADING);
    }

    public function resetState(): static
    {
        $this->dispatch(RadioComponentEvent::RESET);
        $this->selected(false);

        return $this;
    }

    protected function currentState(): RadioComponentState
    {
        if ($this->state instanceof RadioComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return RadioComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de radio inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual de radio no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'type' => $this->type(),
            'value' => $this->value(),
            'group' => $this->group(),
            'selected' => $this->selected(),
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
            'group' => $this->group(),
            'selected' => $this->selected(),
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

        $this->accessibilityState->ariaHidden = $stateValue === RadioComponentState::DISABLED->value;
        $this->accessibilityState->ariaBusy = $stateValue === RadioComponentState::LOADING->value;
        $this->accessibilityState->ariaInvalid = $stateValue === RadioComponentState::INVALID->value;
        $this->accessibilityState->ariaReadonly = $stateValue === RadioComponentState::READONLY->value;
        $this->accessibilityState->ariaChecked = $this->selected() ? 'true' : 'false';
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
