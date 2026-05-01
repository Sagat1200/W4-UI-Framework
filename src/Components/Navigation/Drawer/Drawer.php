<?php

namespace W4\UI\Framework\Components\Navigation\Drawer;

use InvalidArgumentException;
use W4\UI\Framework\Components\Navigation\Drawer\DrawerAccessibilityState;
use W4\UI\Framework\Components\Navigation\Drawer\DrawerComponentEvent;
use W4\UI\Framework\Components\Navigation\Drawer\DrawerComponentState;
use W4\UI\Framework\Components\Navigation\Drawer\DrawerInteractState;
use W4\UI\Framework\Components\Navigation\Drawer\DrawerStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Drawer extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected bool $open = false;

    protected string $position = 'right';

    protected bool $overlay = true;

    protected DrawerInteractState $interactState;

    protected DrawerAccessibilityState $accessibilityState;

    protected DrawerStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->state = DrawerComponentState::CLOSED;
        $this->interactState = new DrawerInteractState();
        $this->accessibilityState = new DrawerAccessibilityState();
        $this->stateMachine = new DrawerStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'drawer';
    }

    public function open(?bool $open = null): bool|static
    {
        if ($open === null) {
            return $this->open;
        }

        if ($open) {
            $this->dispatch(DrawerComponentEvent::OPEN);
        } else {
            $this->dispatch(DrawerComponentEvent::CLOSE);
        }

        return $this;
    }

    public function toggle(): static
    {
        return $this->dispatch(DrawerComponentEvent::TOGGLE);
    }

    public function position(?string $position = null): string|static
    {
        if ($position === null) {
            return $this->position;
        }

        $this->position = $position;
        $this->interactState()->position = $position;

        return $this;
    }

    public function overlay(?bool $overlay = null): bool|static
    {
        if ($overlay === null) {
            return $this->overlay;
        }

        $this->overlay = $overlay;
        $this->interactState()->overlay = $overlay;

        return $this;
    }

    public function interactState(?DrawerInteractState $state = null): DrawerInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?DrawerAccessibilityState $state = null): DrawerAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(DrawerComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(DrawerComponentEvent $event): static
    {
        if ($this->can($event)) {
            $this->state($this->stateMachine->transition($this->currentState(), $event));

            $this->open = $this->currentState() === DrawerComponentState::OPEN;
            $this->interactState()->open = $this->open;

            $this->syncAccessibilityState();
        }

        return $this;
    }

    protected function currentState(): DrawerComponentState
    {
        if ($this->state instanceof DrawerComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return DrawerComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de drawer inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del drawer no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'open' => $this->open(),
            'position' => $this->position(),
            'overlay' => $this->overlay(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
            'accessibility_state' => $this->accessibilityState()->toArray(),
            'accessibility_attributes' => $this->accessibilityState()->toAttributes(),
        ]);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'open' => $this->open(),
            'position' => $this->position(),
            'overlay' => $this->overlay(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
            'accessibility_state' => $this->accessibilityState()->toArray(),
            'accessibility_attributes' => $this->accessibilityState()->toAttributes(),
        ]);
    }

    protected function syncAccessibilityState(): void
    {
        $isOpen = $this->open();

        $this->accessibilityState->ariaHidden = !$isOpen;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}