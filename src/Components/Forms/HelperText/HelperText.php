<?php

namespace W4\UiFramework\Components\Forms\HelperText;

use InvalidArgumentException;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class HelperText extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $text = null;

    protected ?string $forField = null;

    protected ?string $icon = null;

    protected HelperTextInteractState $interactState;

    protected HelperTextStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'neutral';
        $this->size = 'sm';
        $this->state = HelperTextComponentState::ENABLED;
        $this->interactState = new HelperTextInteractState();
        $this->stateMachine = new HelperTextStateMachine();
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

    public function can(HelperTextComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(HelperTextComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

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
        ]);
    }
}
