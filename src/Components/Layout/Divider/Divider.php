<?php

namespace W4\UI\Framework\Components\Layout\Divider;

use InvalidArgumentException;
use W4\UI\Framework\Components\Layout\Divider\DividerAccessibilityState;
use W4\UI\Framework\Components\Layout\Divider\DividerInteractState;
use W4\UI\Framework\Components\Layout\Divider\DividerStateMachine;
use W4\UI\Framework\Components\Layout\Divider\DividerComponentEvent;
use W4\UI\Framework\Components\Layout\Divider\DividerComponentState;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Divider extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $text = null;

    protected string $orientation = 'horizontal';

    protected DividerInteractState $interactState;

    protected DividerAccessibilityState $accessibilityState;

    protected DividerStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'neutral';
        $this->size = 'md';
        $this->state = DividerComponentState::ENABLED;
        $this->interactState = new DividerInteractState();
        $this->accessibilityState = new DividerAccessibilityState();
        $this->stateMachine = new DividerStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'divider';
    }

    public function text(?string $text = null): string|static|null
    {
        if ($text === null) {
            return $this->text;
        }

        $this->text = $text;

        return $this;
    }

    public function orientation(?string $orientation = null): string|static
    {
        if ($orientation === null) {
            return $this->orientation;
        }

        $normalized = strtolower(trim($orientation));
        $allowed = ['horizontal', 'vertical'];

        if (! in_array($normalized, $allowed, true)) {
            throw new InvalidArgumentException('Orientación de divider inválida [' . $orientation . ']');
        }

        $this->orientation = $normalized;
        $this->syncAccessibilityState();

        return $this;
    }

    public function interactState(?DividerInteractState $state = null): DividerInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?DividerAccessibilityState $state = null): DividerAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(DividerComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(DividerComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(DividerComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(DividerComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(DividerComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(DividerComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(DividerComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(DividerComponentEvent::SHOW);
    }

    public function resetState(): static
    {
        return $this->dispatch(DividerComponentEvent::RESET);
    }

    protected function currentState(): DividerComponentState
    {
        if ($this->state instanceof DividerComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return DividerComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de divider inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del divider no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'text' => $this->text(),
            'orientation' => $this->orientation(),
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
            'text' => $this->text(),
            'orientation' => $this->orientation(),
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
        $this->accessibilityState->ariaHidden = $stateValue === DividerComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === DividerComponentState::ACTIVE->value;
        $this->accessibilityState->ariaOrientation = $this->orientation();
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
