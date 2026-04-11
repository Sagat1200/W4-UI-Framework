<?php

namespace W4\UiFramework\Components\UI\Heading;

use InvalidArgumentException;
use W4\UiFramework\Components\UI\Heading\HeadingComponentEvent;
use W4\UiFramework\Components\UI\Heading\HeadingComponentState;
use W4\UiFramework\Components\UI\Heading\HeadingInteractState;
use W4\UiFramework\Components\UI\Heading\HeadingStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Heading extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize {
        size as private traitSize;
    }
    use InteractsWithState;

    protected ?string $text = null;

    protected string $level = 'h2';

    protected bool $hasExplicitSize = false;

    protected HeadingInteractState $interactState;

    protected HeadingStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'neutral';
        $this->size = 'md';
        $this->state = HeadingComponentState::ENABLED;
        $this->interactState = new HeadingInteractState();
        $this->stateMachine = new HeadingStateMachine();
    }

    public function componentName(): string
    {
        return 'heading';
    }

    public function text(?string $text = null): string|static|null
    {
        if ($text === null) {
            return $this->text;
        }

        $this->text = $text;

        return $this;
    }

    public function level(?string $level = null): string|static
    {
        if ($level === null) {
            return $this->level;
        }

        $normalized = strtolower(trim($level));
        $allowed = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

        if (! in_array($normalized, $allowed, true)) {
            throw new InvalidArgumentException('Nivel de heading inválido [' . $level . ']');
        }

        $this->level = $normalized;

        if (! $this->hasExplicitSize) {
            $this->traitSize($this->sizeFromLevel($normalized));
        }

        return $this;
    }

    public function size(?string $size = null): string|static|null
    {
        if ($size === null) {
            return $this->traitSize();
        }

        $this->hasExplicitSize = true;

        return $this->traitSize($size);
    }

    public function interactState(?HeadingInteractState $state = null): HeadingInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(HeadingComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(HeadingComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(HeadingComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(HeadingComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(HeadingComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(HeadingComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(HeadingComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(HeadingComponentEvent::SHOW);
    }

    public function resetState(): static
    {
        return $this->dispatch(HeadingComponentEvent::RESET);
    }

    protected function currentState(): HeadingComponentState
    {
        if ($this->state instanceof HeadingComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return HeadingComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de heading inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del heading no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'text' => $this->text(),
            'level' => $this->level(),
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
            'level' => $this->level(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }

    protected function sizeFromLevel(string $level): string
    {
        return match ($level) {
            'h1' => 'xl',
            'h2' => 'md',
            'h3' => 'sm',
            'h4', 'h5', 'h6' => 'xs',
            default => 'md',
        };
    }
}
