<?php

namespace W4\UiFramework\Components\FeedBack\Alert;

use InvalidArgumentException;
use W4\UiFramework\Components\FeedBack\Alert\AlertComponentEvent;
use W4\UiFramework\Components\FeedBack\Alert\AlertComponentState;
use W4\UiFramework\Components\FeedBack\Alert\AlertInteractState;
use W4\UiFramework\Components\FeedBack\Alert\AlertStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Alert extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $title = null;

    protected ?string $message = null;

    protected ?string $icon = null;

    protected bool $dismissible = true;

    protected bool $dismissed = false;

    protected ?string $tone = 'info';

    protected AlertInteractState $interactState;

    protected AlertStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = AlertComponentState::ENABLED;
        $this->interactState = new AlertInteractState();
        $this->stateMachine = new AlertStateMachine();
    }

    public function componentName(): string
    {
        return 'alert';
    }

    public function title(?string $title = null): string|static|null
    {
        if ($title === null) {
            return $this->title;
        }

        $this->title = $title;

        return $this;
    }

    public function message(?string $message = null): string|static|null
    {
        if ($message === null) {
            return $this->message;
        }

        $this->message = $message;

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

    public function dismissible(?bool $dismissible = null): bool|static
    {
        if ($dismissible === null) {
            return $this->dismissible;
        }

        $this->dismissible = $dismissible;

        return $this;
    }

    public function dismissed(?bool $dismissed = null): bool|static
    {
        if ($dismissed === null) {
            return $this->dismissed;
        }

        $this->dismissed = $dismissed;
        $this->interactState()->dismissed = $dismissed;

        return $this;
    }

    public function tone(?string $tone = null): string|static|null
    {
        if ($tone === null) {
            return $this->tone;
        }

        $this->tone = $tone;

        return $this;
    }

    public function interactState(?AlertInteractState $state = null): AlertInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(AlertComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(AlertComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(AlertComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(AlertComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(AlertComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(AlertComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(AlertComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(AlertComponentEvent::SHOW);
    }

    public function dismiss(): static
    {
        $this->dispatch(AlertComponentEvent::DISMISS);
        $this->dismissed(true);

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(AlertComponentEvent::RESET);
        $this->dismissed(false);

        return $this;
    }

    protected function currentState(): AlertComponentState
    {
        if ($this->state instanceof AlertComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return AlertComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de alert inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del alert no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'title' => $this->title(),
            'message' => $this->message(),
            'icon' => $this->icon(),
            'dismissible' => $this->dismissible(),
            'dismissed' => $this->dismissed(),
            'tone' => $this->tone(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'title' => $this->title(),
            'message' => $this->message(),
            'icon' => $this->icon(),
            'dismissible' => $this->dismissible(),
            'dismissed' => $this->dismissed(),
            'tone' => $this->tone(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
