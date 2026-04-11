<?php

namespace W4\UiFramework\Components\Navigation\DropDown;

use InvalidArgumentException;
use W4\UiFramework\Components\Navigation\DropDown\DropDownAccessibilityState;
use W4\UiFramework\Components\Navigation\DropDown\DropDownComponentEvent;
use W4\UiFramework\Components\Navigation\DropDown\DropDownComponentState;
use W4\UiFramework\Components\Navigation\DropDown\DropDownInteractState;
use W4\UiFramework\Components\Navigation\DropDown\DropDownStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class DropDown extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $label = null;

    protected ?array $items = null;

    protected ?string $placement = 'bottom-start';

    protected bool $opened = false;

    protected bool $searchable = false;

    protected ?string $trigger = 'click';

    protected DropDownInteractState $interactState;

    protected DropDownAccessibilityState $accessibilityState;

    protected DropDownStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = DropDownComponentState::ENABLED;
        $this->interactState = new DropDownInteractState();
        $this->accessibilityState = new DropDownAccessibilityState();
        $this->stateMachine = new DropDownStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'dropdown';
    }

    public function label(?string $label = null): string|static|null
    {
        if ($label === null) {
            return $this->label;
        }

        $this->label = $label;

        return $this;
    }

    public function items(?array $items = null): array|static|null
    {
        if ($items === null) {
            return $this->items;
        }

        $this->items = $items;

        return $this;
    }

    public function addItem(array $item): static
    {
        $items = $this->items ?? [];
        $items[] = $item;
        $this->items = $items;

        return $this;
    }

    public function placement(?string $placement = null): string|static|null
    {
        if ($placement === null) {
            return $this->placement;
        }

        $this->placement = $placement;

        return $this;
    }

    public function opened(?bool $opened = null): bool|static
    {
        if ($opened === null) {
            return $this->opened;
        }

        $this->opened = $opened;
        $this->interactState()->opened = $opened;
        $this->syncAccessibilityState();

        return $this;
    }

    public function searchable(?bool $searchable = null): bool|static
    {
        if ($searchable === null) {
            return $this->searchable;
        }

        $this->searchable = $searchable;

        return $this;
    }

    public function trigger(?string $trigger = null): string|static|null
    {
        if ($trigger === null) {
            return $this->trigger;
        }

        $this->trigger = $trigger;

        return $this;
    }

    public function interactState(?DropDownInteractState $state = null): DropDownInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?DropDownAccessibilityState $state = null): DropDownAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(DropDownComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(DropDownComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(DropDownComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(DropDownComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(DropDownComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(DropDownComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(DropDownComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(DropDownComponentEvent::SHOW);
    }

    public function open(): static
    {
        $this->dispatch(DropDownComponentEvent::OPEN);
        $this->opened(true);

        return $this;
    }

    public function close(): static
    {
        $this->dispatch(DropDownComponentEvent::CLOSE);
        $this->opened(false);

        return $this;
    }

    public function toggle(): static
    {
        $this->dispatch(DropDownComponentEvent::TOGGLE);
        $this->opened(! $this->opened());

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(DropDownComponentEvent::RESET);
        $this->opened(false);

        return $this;
    }

    protected function currentState(): DropDownComponentState
    {
        if ($this->state instanceof DropDownComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return DropDownComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de dropdown inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del dropdown no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'label' => $this->label(),
            'items' => $this->items(),
            'placement' => $this->placement(),
            'opened' => $this->opened(),
            'searchable' => $this->searchable(),
            'trigger' => $this->trigger(),
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
            'items' => $this->items(),
            'placement' => $this->placement(),
            'opened' => $this->opened(),
            'searchable' => $this->searchable(),
            'trigger' => $this->trigger(),
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
        $isOpen = $this->opened() || $stateValue === DropDownComponentState::OPEN->value;

        $this->accessibilityState->ariaExpanded = $isOpen;
        $this->accessibilityState->ariaHidden = ! $isOpen || $stateValue === DropDownComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === DropDownComponentState::ACTIVE->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}