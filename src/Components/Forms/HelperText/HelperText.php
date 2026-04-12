<?php

namespace W4\UI\Framework\Components\Forms\HelperText;

use InvalidArgumentException;
use W4\UI\Framework\Components\Forms\HelperText\HelperTextAccessibilityState;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;
use W4\UI\Framework\Components\Forms\HelperText\HelperTextComponentEvent;
use W4\UI\Framework\Components\Forms\HelperText\HelperTextComponentState;
use W4\UI\Framework\Components\Forms\HelperText\HelperTextInteractState;
use W4\UI\Framework\Components\Forms\HelperText\HelperTextStateMachine;

class HelperText extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $text = null;

    protected ?string $forField = null;

    protected ?string $icon = null;

    protected HelperTextInteractState $interactState;

    protected HelperTextAccessibilityState $accessibilityState;

    protected HelperTextStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'neutral';
        $this->size = 'sm';
        $this->state = HelperTextComponentState::ENABLED;
        $this->interactState = new HelperTextInteractState();
        $this->accessibilityState = new HelperTextAccessibilityState();
        $this->stateMachine = new HelperTextStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'helper-text';
    }

    public function text(?string $text = null): string|static|null
    {
        if ($text === null) {
            return $this->text;
        }

        $this->text = $text;

        return $this;
    }

    public function forField(?string $forField = null): string|static|null
    {
        if ($forField === null) {
            return $this->forField;
        }

        $this->forField = $forField;

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

    public function interactState(?HelperTextInteractState $state = null): HelperTextInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?HelperTextAccessibilityState $state = null): HelperTextAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(HelperTextComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(HelperTextComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(HelperTextComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(HelperTextComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(HelperTextComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(HelperTextComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(HelperTextComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(HelperTextComponentEvent::SHOW);
    }

    public function resetState(): static
    {
        return $this->dispatch(HelperTextComponentEvent::RESET);
    }

    protected function currentState(): HelperTextComponentState
    {
        if ($this->state instanceof HelperTextComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return HelperTextComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de helper-text inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual de helper-text no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'text' => $this->text(),
            'for_field' => $this->forField(),
            'icon' => $this->icon(),
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
            'for_field' => $this->forField(),
            'icon' => $this->icon(),
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

        $this->accessibilityState->ariaHidden = $stateValue === HelperTextComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = false;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}