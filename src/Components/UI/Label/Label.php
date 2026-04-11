<?php

namespace W4\UiFramework\Components\UI\Label;

use InvalidArgumentException;
use W4\UiFramework\Components\UI\Label\LabelAccessibilityState;
use W4\UiFramework\Components\UI\Label\LabelComponentEvent;
use W4\UiFramework\Components\UI\Label\LabelComponentState;
use W4\UiFramework\Components\UI\Label\LabelInteractState;
use W4\UiFramework\Components\UI\Label\LabelStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Label extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $text = null;

    protected ?string $for = null;

    protected LabelInteractState $interactState;

    protected LabelAccessibilityState $accessibilityState;

    protected LabelStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'neutral';
        $this->size = 'md';
        $this->state = LabelComponentState::ENABLED;
        $this->interactState = new LabelInteractState();
        $this->accessibilityState = new LabelAccessibilityState();
        $this->stateMachine = new LabelStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'label';
    }

    public function text(?string $text = null): string|static|null
    {
        if ($text === null) {
            return $this->text;
        }

        $this->text = $text;

        return $this;
    }

    public function for(?string $for = null): string|static|null
    {
        if ($for === null) {
            return $this->for;
        }

        $this->for = trim($for);

        return $this;
    }

    public function interactState(?LabelInteractState $state = null): LabelInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?LabelAccessibilityState $state = null): LabelAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(LabelComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(LabelComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(LabelComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(LabelComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(LabelComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(LabelComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(LabelComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(LabelComponentEvent::SHOW);
    }

    public function resetState(): static
    {
        return $this->dispatch(LabelComponentEvent::RESET);
    }

    protected function currentState(): LabelComponentState
    {
        if ($this->state instanceof LabelComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return LabelComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de label inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del label no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'text' => $this->text(),
            'for' => $this->for(),
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
            'for' => $this->for(),
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

        $this->accessibilityState->ariaDisabled = $stateValue === LabelComponentState::DISABLED->value ? 'true' : 'false';
        $this->accessibilityState->ariaHidden = $stateValue === LabelComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === LabelComponentState::ACTIVE->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}