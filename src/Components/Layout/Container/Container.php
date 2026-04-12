<?php

namespace W4\UI\Framework\Components\Layout\Container;

use InvalidArgumentException;
use W4\UI\Framework\Components\Layout\Container\ContainerAccessibilityState;
use W4\UI\Framework\Components\Layout\Container\ContainerComponentEvent;
use W4\UI\Framework\Components\Layout\Container\ContainerComponentState;
use W4\UI\Framework\Components\Layout\Container\ContainerInteractState;
use W4\UI\Framework\Components\Layout\Container\ContainerStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Container extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $content = null;

    protected ?string $maxWidth = 'lg';

    protected bool $fluid = false;

    protected bool $centered = true;

    protected bool $padded = true;

    protected ?string $gap = 'md';

    protected ContainerInteractState $interactState;

    protected ContainerAccessibilityState $accessibilityState;

    protected ContainerStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = ContainerComponentState::ENABLED;
        $this->interactState = new ContainerInteractState();
        $this->accessibilityState = new ContainerAccessibilityState();
        $this->stateMachine = new ContainerStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'container';
    }

    public function content(?string $content = null): string|static|null
    {
        if ($content === null) {
            return $this->content;
        }

        $this->content = $content;

        return $this;
    }

    public function maxWidth(?string $maxWidth = null): string|static|null
    {
        if ($maxWidth === null) {
            return $this->maxWidth;
        }

        $this->maxWidth = $maxWidth;

        return $this;
    }

    public function fluid(?bool $fluid = null): bool|static
    {
        if ($fluid === null) {
            return $this->fluid;
        }

        $this->fluid = $fluid;
        $this->interactState()->fluid = $fluid;

        return $this;
    }

    public function centered(?bool $centered = null): bool|static
    {
        if ($centered === null) {
            return $this->centered;
        }

        $this->centered = $centered;

        return $this;
    }

    public function padded(?bool $padded = null): bool|static
    {
        if ($padded === null) {
            return $this->padded;
        }

        $this->padded = $padded;

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

    public function interactState(?ContainerInteractState $state = null): ContainerInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?ContainerAccessibilityState $state = null): ContainerAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(ContainerComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(ContainerComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(ContainerComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(ContainerComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(ContainerComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(ContainerComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(ContainerComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(ContainerComponentEvent::SHOW);
    }

    public function setFluid(): static
    {
        $this->dispatch(ContainerComponentEvent::SET_FLUID);
        $this->fluid(true);

        return $this;
    }

    public function setFixed(): static
    {
        $this->dispatch(ContainerComponentEvent::SET_FIXED);
        $this->fluid(false);

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(ContainerComponentEvent::RESET);
        $this->fluid(false);

        return $this;
    }

    protected function currentState(): ContainerComponentState
    {
        if ($this->state instanceof ContainerComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return ContainerComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de container inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del container no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'content' => $this->content(),
            'max_width' => $this->maxWidth(),
            'fluid' => $this->fluid(),
            'centered' => $this->centered(),
            'padded' => $this->padded(),
            'gap' => $this->gap(),
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
            'content' => $this->content(),
            'max_width' => $this->maxWidth(),
            'fluid' => $this->fluid(),
            'centered' => $this->centered(),
            'padded' => $this->padded(),
            'gap' => $this->gap(),
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
        $this->accessibilityState->ariaHidden = $stateValue === ContainerComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === ContainerComponentState::ACTIVE->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
