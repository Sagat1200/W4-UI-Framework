<?php

namespace W4\UI\Framework\Components\Layout\Grid;

use InvalidArgumentException;
use W4\UI\Framework\Components\Layout\Grid\GridAccessibilityState;
use W4\UI\Framework\Components\Layout\Grid\GridComponentEvent;
use W4\UI\Framework\Components\Layout\Grid\GridComponentState;
use W4\UI\Framework\Components\Layout\Grid\GridInteractState;
use W4\UI\Framework\Components\Layout\Grid\GridStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Grid extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?array $items = null;

    protected int $columns = 12;

    protected ?string $gap = 'md';

    protected ?string $rowGap = null;

    protected ?string $columnGap = null;

    protected bool $dense = false;

    protected ?string $alignItems = null;

    protected ?string $justifyItems = null;

    protected GridInteractState $interactState;

    protected GridAccessibilityState $accessibilityState;

    protected GridStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = GridComponentState::ENABLED;
        $this->interactState = new GridInteractState();
        $this->accessibilityState = new GridAccessibilityState();
        $this->stateMachine = new GridStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'grid';
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

    public function columns(?int $columns = null): int|static
    {
        if ($columns === null) {
            return $this->columns;
        }

        $this->columns = $columns;

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

    public function rowGap(?string $rowGap = null): string|static|null
    {
        if ($rowGap === null) {
            return $this->rowGap;
        }

        $this->rowGap = $rowGap;

        return $this;
    }

    public function columnGap(?string $columnGap = null): string|static|null
    {
        if ($columnGap === null) {
            return $this->columnGap;
        }

        $this->columnGap = $columnGap;

        return $this;
    }

    public function dense(?bool $dense = null): bool|static
    {
        if ($dense === null) {
            return $this->dense;
        }

        $this->dense = $dense;
        $this->interactState()->dense = $dense;

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

    public function justifyItems(?string $justifyItems = null): string|static|null
    {
        if ($justifyItems === null) {
            return $this->justifyItems;
        }

        $this->justifyItems = $justifyItems;

        return $this;
    }

    public function interactState(?GridInteractState $state = null): GridInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?GridAccessibilityState $state = null): GridAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(GridComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(GridComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(GridComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(GridComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(GridComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(GridComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(GridComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(GridComponentEvent::SHOW);
    }

    public function setDense(): static
    {
        $this->dispatch(GridComponentEvent::SET_DENSE);
        $this->dense(true);

        return $this;
    }

    public function setRelaxed(): static
    {
        $this->dispatch(GridComponentEvent::SET_RELAXED);
        $this->dense(false);

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(GridComponentEvent::RESET);
        $this->dense(false);

        return $this;
    }

    protected function currentState(): GridComponentState
    {
        if ($this->state instanceof GridComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return GridComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de grid inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del grid no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'items' => $this->items(),
            'columns' => $this->columns(),
            'gap' => $this->gap(),
            'row_gap' => $this->rowGap(),
            'column_gap' => $this->columnGap(),
            'dense' => $this->dense(),
            'align_items' => $this->alignItems(),
            'justify_items' => $this->justifyItems(),
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
            'columns' => $this->columns(),
            'gap' => $this->gap(),
            'row_gap' => $this->rowGap(),
            'column_gap' => $this->columnGap(),
            'dense' => $this->dense(),
            'align_items' => $this->alignItems(),
            'justify_items' => $this->justifyItems(),
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
        $this->accessibilityState->ariaHidden = $stateValue === GridComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === GridComponentState::ACTIVE->value;
        $this->accessibilityState->ariaColCount = $this->columns();
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
