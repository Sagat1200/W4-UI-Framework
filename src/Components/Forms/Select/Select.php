<?php

namespace W4\UiFramework\Components\Forms\Select;

use InvalidArgumentException;
use W4\UiFramework\Components\Forms\Select\SelectComponentEvent;
use W4\UiFramework\Components\Forms\Select\SelectComponentState;
use W4\UiFramework\Components\Forms\Select\SelectInteractState;
use W4\UiFramework\Components\Forms\Select\SelectStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Select extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $type = 'select';

    protected array $options = [];

    protected string|array|null $selected = null;

    protected ?string $placeholder = null;

    protected bool $multiple = false;

    protected ?string $helperText = null;

    protected ?string $errorMessage = null;

    protected SelectInteractState $interactState;

    protected SelectStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = SelectComponentState::ENABLED;
        $this->interactState = new SelectInteractState();
        $this->stateMachine = new SelectStateMachine();
    }

    public function componentName(): string
    {
        return 'select';
    }

    public function type(?string $type = null): string|static|null
    {
        if ($type === null) {
            return $this->type;
        }

        $this->type = $type;

        return $this;
    }

    public function options(?array $options = null): array|static
    {
        if ($options === null) {
            return $this->options;
        }

        $this->options = $options;

        return $this;
    }

    public function addOption(string|int $value, string $label): static
    {
        $this->options[(string) $value] = $label;

        return $this;
    }

    public function selected(string|array|null $selected = null): string|array|static|null
    {
        if (func_num_args() === 0) {
            return $this->selected;
        }

        if ($this->multiple && is_string($selected)) {
            $this->selected = [$selected];

            return $this;
        }

        $this->selected = $selected;

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

    public function multiple(?bool $multiple = null): bool|static
    {
        if ($multiple === null) {
            return $this->multiple;
        }

        $this->multiple = $multiple;

        if (! $multiple && is_array($this->selected)) {
            $this->selected = $this->selected[0] ?? null;
        }

        if ($multiple && is_string($this->selected)) {
            $this->selected = [$this->selected];
        }

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

    public function interactState(?SelectInteractState $state = null): SelectInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(SelectComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(SelectComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function select(string|int|array|null $value): static
    {
        $this->dispatch(SelectComponentEvent::SELECT);

        if ($value === null) {
            $this->selected(null);

            return $this;
        }

        if ($this->multiple()) {
            $values = is_array($value) ? $value : [$value];
            $this->selected(array_values(array_map(static fn($item) => (string) $item, $values)));

            return $this;
        }

        if (is_array($value)) {
            $value = $value[0] ?? null;
        }

        $this->selected($value === null ? null : (string) $value);

        return $this;
    }

    public function clearSelection(): static
    {
        $this->dispatch(SelectComponentEvent::CLEAR);
        $this->selected(null);

        return $this;
    }

    public function disable(): static
    {
        return $this->dispatch(SelectComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(SelectComponentEvent::ENABLE);
    }

    public function setReadonly(): static
    {
        return $this->dispatch(SelectComponentEvent::SET_READONLY);
    }

    public function setInvalid(): static
    {
        return $this->dispatch(SelectComponentEvent::SET_INVALID);
    }

    public function setValid(): static
    {
        return $this->dispatch(SelectComponentEvent::SET_VALID);
    }

    public function startLoading(): static
    {
        return $this->dispatch(SelectComponentEvent::START_LOADING);
    }

    public function finishLoading(): static
    {
        return $this->dispatch(SelectComponentEvent::FINISH_LOADING);
    }

    public function resetState(): static
    {
        $this->dispatch(SelectComponentEvent::RESET);
        $this->selected(null);

        return $this;
    }

    protected function currentState(): SelectComponentState
    {
        if ($this->state instanceof SelectComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return SelectComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de select inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual de select no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'type' => $this->type(),
            'options' => $this->options(),
            'selected' => $this->selected(),
            'placeholder' => $this->placeholder(),
            'multiple' => $this->multiple(),
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
            'options' => $this->options(),
            'selected' => $this->selected(),
            'placeholder' => $this->placeholder(),
            'multiple' => $this->multiple(),
            'helper_text' => $this->helperText(),
            'error_message' => $this->errorMessage(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
