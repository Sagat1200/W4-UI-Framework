<?php

namespace W4\UI\Framework\Components\FeedBack\Progress;

use InvalidArgumentException;
use W4\UI\Framework\Components\FeedBack\Progress\ProgressAccessibilityState;
use W4\UI\Framework\Components\FeedBack\Progress\ProgressComponentEvent;
use W4\UI\Framework\Components\FeedBack\Progress\ProgressInteractState;
use W4\UI\Framework\Components\FeedBack\Progress\ProgressStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Progress extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?int $value = 0;

    protected ?int $min = 0;

    protected ?int $max = 100;

    protected bool $indeterminate = false;

    protected bool $striped = false;

    protected bool $animated = false;

    protected ?string $label = null;

    protected ProgressInteractState $interactState;

    protected ProgressAccessibilityState $accessibilityState;

    protected ProgressStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = ProgressComponentState::ENABLED;
        $this->interactState = new ProgressInteractState();
        $this->accessibilityState = new ProgressAccessibilityState();
        $this->stateMachine = new ProgressStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'progress';
    }

    public function value(?int $value = null): int|static|null
    {
        if ($value === null) {
            return $this->value;
        }

        $value = max((int) $this->min(), min((int) $this->max(), $value));
        $this->value = $value;
        $this->syncAccessibilityState();

        return $this;
    }

    public function min(?int $min = null): int|static|null
    {
        if ($min === null) {
            return $this->min;
        }

        $this->min = $min;

        if ($this->value !== null && $this->value < $min) {
            $this->value = $min;
        }

        $this->syncAccessibilityState();

        return $this;
    }

    public function max(?int $max = null): int|static|null
    {
        if ($max === null) {
            return $this->max;
        }

        $this->max = $max;

        if ($this->value !== null && $this->value > $max) {
            $this->value = $max;
        }

        $this->syncAccessibilityState();

        return $this;
    }

    public function indeterminate(?bool $indeterminate = null): bool|static
    {
        if ($indeterminate === null) {
            return $this->indeterminate;
        }

        $this->indeterminate = $indeterminate;
        $this->interactState()->indeterminate = $indeterminate;
        $this->syncAccessibilityState();

        return $this;
    }

    public function striped(?bool $striped = null): bool|static
    {
        if ($striped === null) {
            return $this->striped;
        }

        $this->striped = $striped;

        return $this;
    }

    public function animated(?bool $animated = null): bool|static
    {
        if ($animated === null) {
            return $this->animated;
        }

        $this->animated = $animated;

        return $this;
    }

    public function label(?string $label = null): string|static|null
    {
        if ($label === null) {
            return $this->label;
        }

        $this->label = $label;

        return $this;
    }

    public function interactState(?ProgressInteractState $state = null): ProgressInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?ProgressAccessibilityState $state = null): ProgressAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(ProgressComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(ProgressComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(ProgressComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(ProgressComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(ProgressComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(ProgressComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(ProgressComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(ProgressComponentEvent::SHOW);
    }

    public function startLoading(): static
    {
        $this->dispatch(ProgressComponentEvent::START_LOADING);
        $this->interactState()->loading = true;
        $this->syncAccessibilityState();

        return $this;
    }

    public function stopLoading(): static
    {
        $this->dispatch(ProgressComponentEvent::STOP_LOADING);
        $this->interactState()->loading = false;
        $this->syncAccessibilityState();

        return $this;
    }

    public function setIndeterminate(): static
    {
        $this->dispatch(ProgressComponentEvent::SET_INDETERMINATE);
        $this->indeterminate(true);

        return $this;
    }

    public function setDeterminate(): static
    {
        $this->dispatch(ProgressComponentEvent::SET_DETERMINATE);
        $this->indeterminate(false);

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(ProgressComponentEvent::RESET);
        $this->interactState()->loading = false;
        $this->indeterminate(false);
        $this->value((int) $this->min());

        return $this;
    }

    protected function currentState(): ProgressComponentState
    {
        if ($this->state instanceof ProgressComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return ProgressComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de progress inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del progress no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'value' => $this->value(),
            'min' => $this->min(),
            'max' => $this->max(),
            'indeterminate' => $this->indeterminate(),
            'striped' => $this->striped(),
            'animated' => $this->animated(),
            'label' => $this->label(),
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
            'value' => $this->value(),
            'min' => $this->min(),
            'max' => $this->max(),
            'indeterminate' => $this->indeterminate(),
            'striped' => $this->striped(),
            'animated' => $this->animated(),
            'label' => $this->label(),
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
        $isBusy = $this->interactState()->loading
            || $stateValue === ProgressComponentState::LOADING->value
            || $stateValue === ProgressComponentState::INDETERMINATE->value;

        $this->accessibilityState->ariaHidden = $stateValue === ProgressComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $isBusy;
        $this->accessibilityState->ariaValueMin = $this->min() !== null ? (string) $this->min() : null;
        $this->accessibilityState->ariaValueMax = $this->max() !== null ? (string) $this->max() : null;
        $this->accessibilityState->ariaValueNow = $this->indeterminate() ? null : ($this->value() !== null ? (string) $this->value() : null);
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
