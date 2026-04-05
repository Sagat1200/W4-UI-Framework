<?php

namespace W4\UiFramework\Components\UI\Text;

use InvalidArgumentException;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Text extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $text = null;
    protected TextInteractState $interactState;
    protected TextStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'neutral';
        $this->size = 'md';
        $this->state = TextComponentState::ENABLED;
        $this->interactState = new TextInteractState();
        $this->stateMachine = new TextStateMachine();
    }

    public function componentName(): string
    {
        return 'text';
    }

    public function text(?string $text = null): string|static|null
    {
        if ($text === null) {
            return $this->text;
        }

        $this->text = $text;

        return $this;
    }

    public function interactState(?TextInteractState $state = null): TextInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(TextComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(TextComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(TextComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(TextComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(TextComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(TextComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(TextComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(TextComponentEvent::SHOW);
    }

    public function resetState(): static
    {
        return $this->dispatch(TextComponentEvent::RESET);
    }

    protected function currentState(): TextComponentState
    {
        if ($this->state instanceof TextComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return TextComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de text inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del text no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'text' => $this->text(),
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
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
