<?php

namespace W4\UiFramework\Components\Navigation\Divider;

use InvalidArgumentException;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Divider extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $text = null;

    protected string $orientation = 'horizontal';

    protected DividerInteractState $interactState;

    protected DividerStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'neutral';
        $this->size = 'md';
        $this->state = DividerComponentState::ENABLED;
        $this->interactState = new DividerInteractState();
        $this->stateMachine = new DividerStateMachine();
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

    public function can(DividerComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(DividerComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

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
        ]);
    }
}
