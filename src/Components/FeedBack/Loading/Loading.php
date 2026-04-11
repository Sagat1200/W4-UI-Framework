<?php

namespace W4\UiFramework\Components\FeedBack\Loading;

use InvalidArgumentException;
use W4\UiFramework\Components\FeedBack\Loading\LoadingAccessibilityState;
use W4\UiFramework\Components\FeedBack\Loading\LoadingComponentEvent;
use W4\UiFramework\Components\FeedBack\Loading\LoadingComponentState;
use W4\UiFramework\Components\FeedBack\Loading\LoadingInteractState;
use W4\UiFramework\Components\FeedBack\Loading\LoadingStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Loading extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $label = null;

    protected ?string $type = 'spinner';

    protected ?string $message = null;

    protected bool $overlay = false;

    protected bool $loading = false;

    protected ?string $speed = 'normal';

    protected LoadingInteractState $interactState;

    protected LoadingAccessibilityState $accessibilityState;

    protected LoadingStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = LoadingComponentState::ENABLED;
        $this->interactState = new LoadingInteractState();
        $this->accessibilityState = new LoadingAccessibilityState();
        $this->stateMachine = new LoadingStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'loading';
    }

    public function label(?string $label = null): string|static|null
    {
        if ($label === null) {
            return $this->label;
        }

        $this->label = $label;

        return $this;
    }

    public function type(?string $type = null): string|static|null
    {
        if ($type === null) {
            return $this->type;
        }

        $this->type = $type;

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

    public function overlay(?bool $overlay = null): bool|static
    {
        if ($overlay === null) {
            return $this->overlay;
        }

        $this->overlay = $overlay;

        return $this;
    }

    public function loading(?bool $loading = null): bool|static
    {
        if ($loading === null) {
            return $this->loading;
        }

        $this->loading = $loading;
        $this->interactState()->loading = $loading;
        $this->syncAccessibilityState();

        return $this;
    }

    public function speed(?string $speed = null): string|static|null
    {
        if ($speed === null) {
            return $this->speed;
        }

        $this->speed = $speed;

        return $this;
    }

    public function interactState(?LoadingInteractState $state = null): LoadingInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?LoadingAccessibilityState $state = null): LoadingAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(LoadingComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(LoadingComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(LoadingComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(LoadingComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(LoadingComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(LoadingComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(LoadingComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(LoadingComponentEvent::SHOW);
    }

    public function start(): static
    {
        $this->dispatch(LoadingComponentEvent::START);
        $this->loading(true);

        return $this;
    }

    public function stop(): static
    {
        $this->dispatch(LoadingComponentEvent::STOP);
        $this->loading(false);

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(LoadingComponentEvent::RESET);
        $this->loading(false);

        return $this;
    }

    protected function currentState(): LoadingComponentState
    {
        if ($this->state instanceof LoadingComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return LoadingComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de loading inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del loading no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'label' => $this->label(),
            'type' => $this->type(),
            'message' => $this->message(),
            'overlay' => $this->overlay(),
            'loading' => $this->loading(),
            'speed' => $this->speed(),
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
            'label' => $this->label(),
            'type' => $this->type(),
            'message' => $this->message(),
            'overlay' => $this->overlay(),
            'loading' => $this->loading(),
            'speed' => $this->speed(),
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

        $this->accessibilityState->ariaHidden = $stateValue === LoadingComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $this->loading() || $stateValue === LoadingComponentState::LOADING->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
