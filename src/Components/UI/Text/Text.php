<?php

namespace W4\UI\Framework\Components\UI\Text;

use InvalidArgumentException;
use W4\UI\Framework\Components\UI\Text\TextAccessibilityState;
use W4\UI\Framework\Components\UI\Text\TextComponentEvent;
use W4\UI\Framework\Components\UI\Text\TextComponentState;
use W4\UI\Framework\Components\UI\Text\TextInteractState;
use W4\UI\Framework\Components\UI\Text\TextStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Text extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $text = null;
    protected TextInteractState $interactState;
    protected TextAccessibilityState $accessibilityState;
    protected TextStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'neutral';
        $this->size = 'md';
        $this->state = TextComponentState::ENABLED;
        $this->interactState = new TextInteractState();
        $this->accessibilityState = new TextAccessibilityState();
        $this->stateMachine = new TextStateMachine();
        $this->syncAccessibilityState();
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

    public function accessibilityState(?TextAccessibilityState $state = null): TextAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(TextComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(TextComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

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
            'accessibility_state' => $this->accessibilityState()->toArray(),
            'accessibility_attributes' => $this->accessibilityState()->toAttributes(),
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
            'accessibility_state' => $this->accessibilityState()->toArray(),
            'accessibility_attributes' => $this->accessibilityState()->toAttributes(),
        ]);
    }

    protected function syncAccessibilityState(): void
    {
        $stateValue = (string) $this->stateValue();

        $this->accessibilityState->ariaDisabled = $stateValue === TextComponentState::DISABLED->value ? 'true' : 'false';
        $this->accessibilityState->ariaHidden = $stateValue === TextComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === TextComponentState::ACTIVE->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
