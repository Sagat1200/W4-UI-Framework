<?php

namespace W4\UI\Framework\Components\Forms\Toggle;

use InvalidArgumentException;
use W4\UI\Framework\Components\Forms\Toggle\ToggleAccessibilityState;
use W4\UI\Framework\Components\Forms\Toggle\ToggleComponentEvent;
use W4\UI\Framework\Components\Forms\Toggle\ToggleComponentState;
use W4\UI\Framework\Components\Forms\Toggle\ToggleInteractState;
use W4\UI\Framework\Components\Forms\Toggle\ToggleStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Toggle extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $type = 'toggle';

    protected ?string $value = null;

    protected bool $checked = false;

    protected ?string $helperText = null;

    protected ?string $errorMessage = null;

    protected ToggleInteractState $interactState;

    protected ToggleAccessibilityState $accessibilityState;

    protected ToggleStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = ToggleComponentState::ENABLED;
        $this->interactState = new ToggleInteractState();
        $this->accessibilityState = new ToggleAccessibilityState();
        $this->stateMachine = new ToggleStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'toggle';
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

    public function interactState(?ToggleInteractState $state = null): ToggleInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?ToggleAccessibilityState $state = null): ToggleAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(ToggleComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(ToggleComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function check(): static
    {
        $this->dispatch(ToggleComponentEvent::CHECK);
        $this->checked(true);

        return $this;
    }

    public function uncheck(): static
    {
        $this->dispatch(ToggleComponentEvent::UNCHECK);
        $this->checked(false);

        return $this;
    }

    public function toggle(): static
    {
        $this->dispatch(ToggleComponentEvent::TOGGLE);
        $this->checked(! $this->checked());

        return $this;
    }

    public function disable(): static
    {
        return $this->dispatch(ToggleComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(ToggleComponentEvent::ENABLE);
    }

    public function setReadonly(): static
    {
        return $this->dispatch(ToggleComponentEvent::SET_READONLY);
    }

    public function setInvalid(): static
    {
        return $this->dispatch(ToggleComponentEvent::SET_INVALID);
    }

    public function setValid(): static
    {
        return $this->dispatch(ToggleComponentEvent::SET_VALID);
    }

    public function startLoading(): static
    {
        return $this->dispatch(ToggleComponentEvent::START_LOADING);
    }

    public function finishLoading(): static
    {
        return $this->dispatch(ToggleComponentEvent::FINISH_LOADING);
    }

    public function resetState(): static
    {
        $this->dispatch(ToggleComponentEvent::RESET);
        $this->checked(false);

        return $this;
    }

    protected function currentState(): ToggleComponentState
    {
        if ($this->state instanceof ToggleComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return ToggleComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de toggle inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del toggle no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'type' => $this->type(),
            'value' => $this->value(),
            'checked' => $this->checked(),
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
            'checked' => $this->checked(),
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

        $this->accessibilityState->ariaHidden = $stateValue === ToggleComponentState::DISABLED->value;
        $this->accessibilityState->ariaBusy = $stateValue === ToggleComponentState::LOADING->value;
        $this->accessibilityState->ariaInvalid = $stateValue === ToggleComponentState::INVALID->value;
        $this->accessibilityState->ariaReadonly = $stateValue === ToggleComponentState::READONLY->value;
        $this->accessibilityState->ariaChecked = $this->checked() ? 'true' : 'false';
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
