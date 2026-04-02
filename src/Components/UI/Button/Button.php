<?php

namespace W4\UiFramework\Components\UI\Button;

use InvalidArgumentException;
use W4\UiFramework\Components\UI\Button\ButtonComponentState;
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;
use W4\UiFramework\Components\UI\Button\ButtonInteractState;
use W4\UiFramework\Components\UI\Button\ButtonStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Button extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $icon = null;

    protected ButtonInteractState $interactState;
    protected ButtonStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'primary';
        $this->size = 'md';
        $this->state = ButtonComponentState::ENABLED;
        $this->interactState = new ButtonInteractState();
        $this->stateMachine = new ButtonStateMachine();
    }

    public function componentName(): string
    {
        return 'button';
    }

    public function icon(?string $icon = null): string|static|null
    {
        if ($icon === null) {
            return $this->icon;
        }

        $this->icon = $icon;

        return $this;
    }

    public function interactState(?ButtonInteractState $state = null): ButtonInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(ButtonComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(ButtonComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function click(): static
    {
        return $this->dispatch(ButtonComponentEvent::CLICK);
    }

    public function disable(): static
    {
        return $this->dispatch(ButtonComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(ButtonComponentEvent::ENABLE);
    }

    public function startLoading(): static
    {
        return $this->dispatch(ButtonComponentEvent::START_LOADING);
    }

    public function finishLoading(): static
    {
        return $this->dispatch(ButtonComponentEvent::FINISH_LOADING);
    }

    public function setReadonly(): static
    {
        return $this->dispatch(ButtonComponentEvent::SET_READONLY);
    }

    public function setActive(): static
    {
        return $this->dispatch(ButtonComponentEvent::SET_ACTIVE);
    }

    public function resetState(): static
    {
        return $this->dispatch(ButtonComponentEvent::RESET);
    }

    protected function currentState(): ButtonComponentState
    {
        if ($this->state instanceof ButtonComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return ButtonComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException("Estado de botón inválido [{$this->state}]");
            }
        }

        throw new InvalidArgumentException('El estado actual del botón no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'variant' => $this->variant(),
            'size' => $this->size(),
            'icon' => $this->icon(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'variant' => $this->variant(),
            'size' => $this->size(),
            'icon' => $this->icon(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
