<?php

namespace W4\UiFramework\Components\Forms\FielError;

use InvalidArgumentException;
use W4\UiFramework\Components\Forms\FielError\FieldErrorComponentEvent;
use W4\UiFramework\Components\Forms\FielError\FieldErrorComponentState;
use W4\UiFramework\Components\Forms\FielError\FieldErrorInteractState;
use W4\UiFramework\Components\Forms\FielError\FieldErrorStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class FieldError extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $message = null;

    protected ?string $forField = null;

    protected ?string $code = null;

    protected ?string $hint = null;

    protected FieldErrorInteractState $interactState;

    protected FieldErrorStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'error';
        $this->size = 'md';
        $this->state = FieldErrorComponentState::ENABLED;
        $this->interactState = new FieldErrorInteractState();
        $this->stateMachine = new FieldErrorStateMachine();
    }

    public function componentName(): string
    {
        return 'field-error';
    }

    public function message(?string $message = null): string|static|null
    {
        if ($message === null) {
            return $this->message;
        }

        $this->message = $message;

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

    public function code(?string $code = null): string|static|null
    {
        if ($code === null) {
            return $this->code;
        }

        $this->code = $code;

        return $this;
    }

    public function hint(?string $hint = null): string|static|null
    {
        if ($hint === null) {
            return $this->hint;
        }

        $this->hint = $hint;

        return $this;
    }

    public function interactState(?FieldErrorInteractState $state = null): FieldErrorInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(FieldErrorComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(FieldErrorComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(FieldErrorComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(FieldErrorComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(FieldErrorComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(FieldErrorComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(FieldErrorComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(FieldErrorComponentEvent::SHOW);
    }

    public function resetState(): static
    {
        return $this->dispatch(FieldErrorComponentEvent::RESET);
    }

    protected function currentState(): FieldErrorComponentState
    {
        if ($this->state instanceof FieldErrorComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return FieldErrorComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de field-error inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual de field-error no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'message' => $this->message(),
            'for_field' => $this->forField(),
            'code' => $this->code(),
            'hint' => $this->hint(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'message' => $this->message(),
            'for_field' => $this->forField(),
            'code' => $this->code(),
            'hint' => $this->hint(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
