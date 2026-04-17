<?php

namespace W4\UI\Framework\Components\Navigation\Tab\TabPane;

use InvalidArgumentException;
use W4\UI\Framework\Components\Navigation\Tab\TabPane\TabPaneAccessibilityState;
use W4\UI\Framework\Components\Navigation\Tab\TabPane\TabPaneComponentEvent;
use W4\UI\Framework\Components\Navigation\Tab\TabPane\TabPaneComponentState;
use W4\UI\Framework\Components\Navigation\Tab\TabPane\TabPaneInteractState;
use W4\UI\Framework\Components\Navigation\Tab\TabPane\TabPaneStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithState;

class TabPane extends BaseComponent
{
    use InteractsWithState;

    protected bool $active = false;

    protected ?string $value = null;

    protected TabPaneInteractState $interactState;

    protected TabPaneAccessibilityState $accessibilityState;

    protected TabPaneStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->state = TabPaneComponentState::ENABLED;
        $this->interactState = new TabPaneInteractState();
        $this->accessibilityState = new TabPaneAccessibilityState();
        $this->stateMachine = new TabPaneStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'tab-pane';
    }

    public function active(?bool $active = null): bool|static
    {
        if ($active === null) {
            return $this->active;
        }

        $this->active = $active;
        $this->interactState()->active = $active;
        $this->syncAccessibilityState();

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

    public function interactState(?TabPaneInteractState $state = null): TabPaneInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?TabPaneAccessibilityState $state = null): TabPaneAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(TabPaneComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(TabPaneComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        $this->dispatch(TabPaneComponentEvent::ACTIVATE);
        $this->active(true);

        return $this;
    }

    public function deactivate(): static
    {
        $this->dispatch(TabPaneComponentEvent::DEACTIVATE);
        $this->active(false);

        return $this;
    }

    public function hide(): static
    {
        return $this->dispatch(TabPaneComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(TabPaneComponentEvent::SHOW);
    }

    public function resetState(): static
    {
        $this->dispatch(TabPaneComponentEvent::RESET);
        $this->active(false);

        return $this;
    }

    protected function currentState(): TabPaneComponentState
    {
        if ($this->state instanceof TabPaneComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return TabPaneComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de tab-pane inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del tab-pane no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'active' => $this->active(),
            'value' => $this->value(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
            'accessibility_state' => $this->accessibilityState()->toArray(),
            'accessibility_attributes' => $this->accessibilityState()->toAttributes(),
        ]);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'active' => $this->active(),
            'value' => $this->value(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
            'accessibility_state' => $this->accessibilityState()->toArray(),
            'accessibility_attributes' => $this->accessibilityState()->toAttributes(),
        ]);
    }

    protected function syncAccessibilityState(): void
    {
        $stateValue = (string) $this->stateValue();
        $isActive = $this->active() || $stateValue === TabPaneComponentState::ACTIVE->value;

        $this->accessibilityState->ariaHidden = !$isActive;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
