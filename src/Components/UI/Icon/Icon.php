<?php

namespace W4\UI\Framework\Components\UI\Icon;

use InvalidArgumentException;
use W4\UI\Framework\Components\UI\Icon\IconAccessibilityState;
use W4\UI\Framework\Components\UI\Icon\IconComponentEvent;
use W4\UI\Framework\Components\UI\Icon\IconComponentState;
use W4\UI\Framework\Components\UI\Icon\IconInteractState;
use W4\UI\Framework\Components\UI\Icon\IconStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Icon extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $icon = null;

    protected bool $spin = false;

    protected bool $decorative = false;

    protected IconInteractState $interactState;

    protected IconAccessibilityState $accessibilityState;

    protected IconStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'neutral';
        $this->size = 'md';
        $this->state = IconComponentState::ENABLED;
        $this->interactState = new IconInteractState();
        $this->accessibilityState = new IconAccessibilityState();
        $this->stateMachine = new IconStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'icon';
    }

    public function icon(?string $icon = null): string|static|null
    {
        if ($icon === null) {
            return $this->icon;
        }

        $this->icon = trim($icon);

        return $this;
    }

    public function spin(?bool $spin = null): bool|static
    {
        if ($spin === null) {
            return $this->spin;
        }

        $this->spin = $spin;

        return $this;
    }

    public function decorative(?bool $decorative = null): bool|static
    {
        if ($decorative === null) {
            return $this->decorative;
        }

        $this->decorative = $decorative;
        $this->syncAccessibilityState();

        return $this;
    }

    public function interactState(?IconInteractState $state = null): IconInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?IconAccessibilityState $state = null): IconAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(IconComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(IconComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(IconComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(IconComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(IconComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(IconComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(IconComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(IconComponentEvent::SHOW);
    }

    public function resetState(): static
    {
        return $this->dispatch(IconComponentEvent::RESET);
    }

    protected function currentState(): IconComponentState
    {
        if ($this->state instanceof IconComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return IconComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de icon inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del icon no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'icon' => $this->icon(),
            'spin' => $this->spin(),
            'decorative' => $this->decorative(),
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
            'icon' => $this->icon(),
            'spin' => $this->spin(),
            'decorative' => $this->decorative(),
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

        $this->accessibilityState->ariaDisabled = $stateValue === IconComponentState::DISABLED->value ? 'true' : 'false';
        $this->accessibilityState->ariaHidden = $this->decorative() || $stateValue === IconComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === IconComponentState::ACTIVE->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
