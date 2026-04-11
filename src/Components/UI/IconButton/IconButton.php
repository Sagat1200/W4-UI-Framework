<?php

namespace W4\UiFramework\Components\UI\IconButton;

use InvalidArgumentException;
use W4\UiFramework\Components\UI\IconButton\IconButtonComponentEvent;
use W4\UiFramework\Components\UI\IconButton\IconButtonComponentState;
use W4\UiFramework\Components\UI\IconButton\IconButtonInteractState;
use W4\UiFramework\Components\UI\IconButton\IconButtonStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class IconButton extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $icon = null;

    protected IconButtonInteractState $interactState;

    protected IconButtonStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'primary';
        $this->size = 'md';
        $this->state = IconButtonComponentState::ENABLED;
        $this->interactState = new IconButtonInteractState();
        $this->stateMachine = new IconButtonStateMachine();
    }

    public function componentName(): string
    {
        return 'icon-button';
    }

    public function icon(?string $icon = null): string|static|null
    {
        if ($icon === null) {
            return $this->icon;
        }

        $this->icon = trim($icon);

        return $this;
    }

    public function interactState(?IconButtonInteractState $state = null): IconButtonInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(IconButtonComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(IconButtonComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function click(): static
    {
        return $this->dispatch(IconButtonComponentEvent::CLICK);
    }

    public function disable(): static
    {
        return $this->dispatch(IconButtonComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(IconButtonComponentEvent::ENABLE);
    }

    public function startLoading(): static
    {
        return $this->dispatch(IconButtonComponentEvent::START_LOADING);
    }

    public function finishLoading(): static
    {
        return $this->dispatch(IconButtonComponentEvent::FINISH_LOADING);
    }

    public function setReadonly(): static
    {
        return $this->dispatch(IconButtonComponentEvent::SET_READONLY);
    }

    public function setActive(): static
    {
        return $this->dispatch(IconButtonComponentEvent::SET_ACTIVE);
    }

    public function resetState(): static
    {
        return $this->dispatch(IconButtonComponentEvent::RESET);
    }

    protected function currentState(): IconButtonComponentState
    {
        if ($this->state instanceof IconButtonComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return IconButtonComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de icon button inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del icon button no es válido.');
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
