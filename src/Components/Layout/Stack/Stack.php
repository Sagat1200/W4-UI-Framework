<?php

namespace W4\UiFramework\Components\Layout\Stack;

use InvalidArgumentException;
use W4\UiFramework\Components\Layout\Stack\StackAccessibilityState;
use W4\UiFramework\Components\Layout\Stack\StackComponentEvent;
use W4\UiFramework\Components\Layout\Stack\StackComponentState;
use W4\UiFramework\Components\Layout\Stack\StackInteractState;
use W4\UiFramework\Components\Layout\Stack\StackStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Stack extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?array $items = null;

    protected ?string $direction = 'vertical';

    protected ?string $gap = 'md';

    protected bool $wrap = false;

    protected ?string $alignItems = null;

    protected ?string $justifyContent = null;

    protected StackInteractState $interactState;

    protected StackAccessibilityState $accessibilityState;

    protected StackStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = StackComponentState::ENABLED;
        $this->interactState = new StackInteractState();
        $this->accessibilityState = new StackAccessibilityState();
        $this->stateMachine = new StackStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'stack';
    }

    public function items(?array $items = null): array|static|null
    {
        if ($items === null) {
            return $this->items;
        }

        $this->items = $items;

        return $this;
    }

    public function addItem(mixed $item): static
    {
        $items = $this->items ?? [];
        $items[] = $item;
        $this->items = $items;

        return $this;
    }

    public function direction(?string $direction = null): string|static|null
    {
        if ($direction === null) {
            return $this->direction;
        }

        $normalized = strtolower(trim($direction));
        $allowed = ['vertical', 'horizontal'];

        if (! in_array($normalized, $allowed, true)) {
            throw new InvalidArgumentException('Dirección de stack inválida [' . $direction . ']');
        }

        $this->direction = $normalized;
        $this->syncAccessibilityState();

        return $this;
    }

    public function gap(?string $gap = null): string|static|null
    {
        if ($gap === null) {
            return $this->gap;
        }

        $this->gap = $gap;

        return $this;
    }

    public function wrap(?bool $wrap = null): bool|static
    {
        if ($wrap === null) {
            return $this->wrap;
        }

        $this->wrap = $wrap;
        $this->interactState()->wrapped = $wrap;

        return $this;
    }

    public function alignItems(?string $alignItems = null): string|static|null
    {
        if ($alignItems === null) {
            return $this->alignItems;
        }

        $this->alignItems = $alignItems;

        return $this;
    }

    public function justifyContent(?string $justifyContent = null): string|static|null
    {
        if ($justifyContent === null) {
            return $this->justifyContent;
        }

        $this->justifyContent = $justifyContent;

        return $this;
    }

    public function interactState(?StackInteractState $state = null): StackInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?StackAccessibilityState $state = null): StackAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(StackComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(StackComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(StackComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(StackComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(StackComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(StackComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(StackComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(StackComponentEvent::SHOW);
    }

    public function setHorizontal(): static
    {
        $this->dispatch(StackComponentEvent::SET_HORIZONTAL);
        $this->direction('horizontal');

        return $this;
    }

    public function setVertical(): static
    {
        $this->dispatch(StackComponentEvent::SET_VERTICAL);
        $this->direction('vertical');

        return $this;
    }

    public function setWrap(): static
    {
        $this->dispatch(StackComponentEvent::SET_WRAP);
        $this->wrap(true);

        return $this;
    }

    public function setNoWrap(): static
    {
        $this->dispatch(StackComponentEvent::SET_NOWRAP);
        $this->wrap(false);

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(StackComponentEvent::RESET);
        $this->direction('vertical');
        $this->wrap(false);

        return $this;
    }

    protected function currentState(): StackComponentState
    {
        if ($this->state instanceof StackComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return StackComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de stack inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del stack no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'items' => $this->items(),
            'direction' => $this->direction(),
            'gap' => $this->gap(),
            'wrap' => $this->wrap(),
            'align_items' => $this->alignItems(),
            'justify_content' => $this->justifyContent(),
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
            'items' => $this->items(),
            'direction' => $this->direction(),
            'gap' => $this->gap(),
            'wrap' => $this->wrap(),
            'align_items' => $this->alignItems(),
            'justify_content' => $this->justifyContent(),
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
        $this->accessibilityState->ariaHidden = $stateValue === StackComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === StackComponentState::ACTIVE->value;
        $this->accessibilityState->ariaOrientation = $this->direction();
        $this->attributes($this->accessibilityState->toAttributes());
    }
}