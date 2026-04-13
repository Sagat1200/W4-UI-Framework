<?php

namespace W4\UI\Framework\Components\FeedBack\Skeleton;

use InvalidArgumentException;
use W4\UI\Framework\Components\FeedBack\Skeleton\SkeletonAccessibilityState;
use W4\UI\Framework\Components\FeedBack\Skeleton\SkeletonComponentEvent;
use W4\UI\Framework\Components\FeedBack\Skeleton\SkeletonComponentState;
use W4\UI\Framework\Components\FeedBack\Skeleton\SkeletonInteractState;
use W4\UI\Framework\Components\FeedBack\Skeleton\SkeletonStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Skeleton extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $shape = 'line';

    protected ?string $width = null;

    protected ?string $height = null;

    protected bool $animated = true;

    protected ?int $lines = 1;

    protected SkeletonInteractState $interactState;

    protected SkeletonAccessibilityState $accessibilityState;

    protected SkeletonStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'line';
        $this->size = 'md';
        $this->state = SkeletonComponentState::ENABLED;
        $this->interactState = new SkeletonInteractState();
        $this->accessibilityState = new SkeletonAccessibilityState();
        $this->stateMachine = new SkeletonStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'skeleton';
    }

    public function shape(?string $shape = null): string|static|null
    {
        if ($shape === null) {
            return $this->shape;
        }

        $this->shape = $shape;

        return $this;
    }

    public function width(?string $width = null): string|static|null
    {
        if ($width === null) {
            return $this->width;
        }

        $this->width = $width;

        return $this;
    }

    public function height(?string $height = null): string|static|null
    {
        if ($height === null) {
            return $this->height;
        }

        $this->height = $height;

        return $this;
    }

    public function animated(?bool $animated = null): bool|static
    {
        if ($animated === null) {
            return $this->animated;
        }

        $this->animated = $animated;
        $this->interactState()->animated = $animated;

        return $this;
    }

    public function lines(?int $lines = null): int|static|null
    {
        if ($lines === null) {
            return $this->lines;
        }

        $this->lines = max(1, $lines);

        return $this;
    }

    public function interactState(?SkeletonInteractState $state = null): SkeletonInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?SkeletonAccessibilityState $state = null): SkeletonAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(SkeletonComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(SkeletonComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(SkeletonComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(SkeletonComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(SkeletonComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(SkeletonComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(SkeletonComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(SkeletonComponentEvent::SHOW);
    }

    public function startLoading(): static
    {
        $this->dispatch(SkeletonComponentEvent::START_LOADING);
        $this->interactState()->loading = true;
        $this->syncAccessibilityState();

        return $this;
    }

    public function stopLoading(): static
    {
        $this->dispatch(SkeletonComponentEvent::STOP_LOADING);
        $this->interactState()->loading = false;
        $this->syncAccessibilityState();

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(SkeletonComponentEvent::RESET);
        $this->interactState()->loading = false;
        $this->animated(true);

        return $this;
    }

    protected function currentState(): SkeletonComponentState
    {
        if ($this->state instanceof SkeletonComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return SkeletonComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de skeleton inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del skeleton no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'shape' => $this->shape(),
            'width' => $this->width(),
            'height' => $this->height(),
            'animated' => $this->animated(),
            'lines' => $this->lines(),
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
            'shape' => $this->shape(),
            'width' => $this->width(),
            'height' => $this->height(),
            'animated' => $this->animated(),
            'lines' => $this->lines(),
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
        $isBusy = $this->interactState()->loading || $stateValue === SkeletonComponentState::LOADING->value;

        $this->accessibilityState->ariaHidden = $stateValue === SkeletonComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $isBusy;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
