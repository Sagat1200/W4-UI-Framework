<?php

namespace W4\UiFramework\Components\Navigation\Tab;

use InvalidArgumentException;
use W4\UiFramework\Components\Navigation\Tab\TabAccessibilityState;
use W4\UiFramework\Components\Navigation\Tab\TabComponentEvent;
use W4\UiFramework\Components\Navigation\Tab\TabComponentState;
use W4\UiFramework\Components\Navigation\Tab\TabInteractState;
use W4\UiFramework\Components\Navigation\Tab\TabStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Tab extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $label = null;

    protected ?string $value = null;

    protected bool $selected = false;

    protected bool $disabled = false;

    protected ?string $icon = null;

    protected ?string $href = null;

    protected TabInteractState $interactState;

    protected TabAccessibilityState $accessibilityState;

    protected TabStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = TabComponentState::ENABLED;
        $this->interactState = new TabInteractState();
        $this->accessibilityState = new TabAccessibilityState();
        $this->stateMachine = new TabStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'tab';
    }

    public function label(?string $label = null): string|static|null
    {
        if ($label === null) {
            return $this->label;
        }

        $this->label = $label;

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

    public function selected(?bool $selected = null): bool|static
    {
        if ($selected === null) {
            return $this->selected;
        }

        $this->selected = $selected;
        $this->interactState()->selected = $selected;
        $this->syncAccessibilityState();

        return $this;
    }

    public function disabled(?bool $disabled = null): bool|static
    {
        if ($disabled === null) {
            return $this->disabled;
        }

        $this->disabled = $disabled;

        return $this;
    }

    public function icon(?string $icon = null): string|static|null
    {
        if ($icon === null) {
            return $this->icon;
        }

        $this->icon = $icon;

        return $this;
    }

    public function href(?string $href = null): string|static|null
    {
        if ($href === null) {
            return $this->href;
        }

        $this->href = $href;

        return $this;
    }

    public function interactState(?TabInteractState $state = null): TabInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?TabAccessibilityState $state = null): TabAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(TabComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(TabComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(TabComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(TabComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        $this->dispatch(TabComponentEvent::DISABLE);
        $this->disabled(true);

        return $this;
    }

    public function enable(): static
    {
        $this->dispatch(TabComponentEvent::ENABLE);
        $this->disabled(false);

        return $this;
    }

    public function hide(): static
    {
        return $this->dispatch(TabComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(TabComponentEvent::SHOW);
    }

    public function select(): static
    {
        $this->dispatch(TabComponentEvent::SELECT);
        $this->selected(true);

        return $this;
    }

    public function unselect(): static
    {
        $this->dispatch(TabComponentEvent::UNSELECT);
        $this->selected(false);

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(TabComponentEvent::RESET);
        $this->selected(false);
        $this->disabled(false);

        return $this;
    }

    protected function currentState(): TabComponentState
    {
        if ($this->state instanceof TabComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return TabComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de tab inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del tab no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'label' => $this->label(),
            'value' => $this->value(),
            'selected' => $this->selected(),
            'disabled' => $this->disabled(),
            'icon' => $this->icon(),
            'href' => $this->href(),
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
            'label' => $this->label(),
            'value' => $this->value(),
            'selected' => $this->selected(),
            'disabled' => $this->disabled(),
            'icon' => $this->icon(),
            'href' => $this->href(),
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
        $isSelected = $this->selected() || $stateValue === TabComponentState::SELECTED->value;

        $this->accessibilityState->ariaSelected = $isSelected;
        $this->accessibilityState->ariaHidden = $stateValue === TabComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === TabComponentState::ACTIVE->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
