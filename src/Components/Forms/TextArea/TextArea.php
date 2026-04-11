<?php

namespace W4\UiFramework\Components\Forms\TextArea;

use InvalidArgumentException;
use W4\UiFramework\Components\Forms\TextArea\TextAreaComponentEvent;
use W4\UiFramework\Components\Forms\TextArea\TextAreaComponentState;
use W4\UiFramework\Components\Forms\TextArea\TextAreaInteractState;
use W4\UiFramework\Components\Forms\TextArea\TextAreaStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class TextArea extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $type = 'textarea';

    protected ?string $value = null;

    protected ?string $placeholder = null;

    protected ?int $rows = 3;

    protected ?int $cols = null;

    protected ?string $resize = 'vertical';

    protected ?string $helperText = null;

    protected ?string $errorMessage = null;

    protected TextAreaInteractState $interactState;

    protected TextAreaStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = TextAreaComponentState::ENABLED;
        $this->interactState = new TextAreaInteractState();
        $this->stateMachine = new TextAreaStateMachine();
    }

    public function componentName(): string
    {
        return 'textarea';
    }

    public function type(?string $type = null): string|static|null
    {
        if ($type === null) {
            return $this->type;
        }

        $this->type = $type;

        return $this;
    }

    public function value(?string $value = null): string|static|null
    {
        if ($value === null) {
            return $this->value;
        }

        $this->value = $value;

        return $this;
    }

    public function placeholder(?string $placeholder = null): string|static|null
    {
        if ($placeholder === null) {
            return $this->placeholder;
        }

        $this->placeholder = $placeholder;

        return $this;
    }

    public function rows(?int $rows = null): int|static|null
    {
        if ($rows === null) {
            return $this->rows;
        }

        $this->rows = $rows;

        return $this;
    }

    public function cols(?int $cols = null): int|static|null
    {
        if ($cols === null) {
            return $this->cols;
        }

        $this->cols = $cols;

        return $this;
    }

    public function resize(?string $resize = null): string|static|null
    {
        if ($resize === null) {
            return $this->resize;
        }

        $this->resize = $resize;

        return $this;
    }

    public function helperText(?string $helperText = null): string|static|null
    {
        if ($helperText === null) {
            return $this->helperText;
        }

        $this->helperText = $helperText;

        return $this;
    }

    public function errorMessage(?string $errorMessage = null): string|static|null
    {
        if ($errorMessage === null) {
            return $this->errorMessage;
        }

        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function interactState(?TextAreaInteractState $state = null): TextAreaInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(TextAreaComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(TextAreaComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function disable(): static
    {
        return $this->dispatch(TextAreaComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(TextAreaComponentEvent::ENABLE);
    }

    public function setReadonly(): static
    {
        return $this->dispatch(TextAreaComponentEvent::SET_READONLY);
    }

    public function setInvalid(): static
    {
        return $this->dispatch(TextAreaComponentEvent::SET_INVALID);
    }

    public function setValid(): static
    {
        return $this->dispatch(TextAreaComponentEvent::SET_VALID);
    }

    public function startLoading(): static
    {
        return $this->dispatch(TextAreaComponentEvent::START_LOADING);
    }

    public function finishLoading(): static
    {
        return $this->dispatch(TextAreaComponentEvent::FINISH_LOADING);
    }

    public function resetState(): static
    {
        return $this->dispatch(TextAreaComponentEvent::RESET);
    }

    protected function currentState(): TextAreaComponentState
    {
        if ($this->state instanceof TextAreaComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return TextAreaComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de textarea inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del textarea no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'type' => $this->type(),
            'value' => $this->value(),
            'placeholder' => $this->placeholder(),
            'rows' => $this->rows(),
            'cols' => $this->cols(),
            'resize' => $this->resize(),
            'helper_text' => $this->helperText(),
            'error_message' => $this->errorMessage(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'type' => $this->type(),
            'value' => $this->value(),
            'placeholder' => $this->placeholder(),
            'rows' => $this->rows(),
            'cols' => $this->cols(),
            'resize' => $this->resize(),
            'helper_text' => $this->helperText(),
            'error_message' => $this->errorMessage(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
