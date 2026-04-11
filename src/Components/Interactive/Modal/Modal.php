<?php

namespace W4\UiFramework\Components\Interactive\Modal;

use InvalidArgumentException;
use W4\UiFramework\Components\Interactive\Modal\ModalComponentEvent;
use W4\UiFramework\Components\Interactive\Modal\ModalComponentState;
use W4\UiFramework\Components\Interactive\Modal\ModalInteractState;
use W4\UiFramework\Components\Interactive\Modal\ModalStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Modal extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $title = null;

    protected ?string $content = null;

    protected ?string $footer = null;

    protected bool $opened = false;

    protected bool $dismissible = true;

    protected ?string $sizePreset = 'md';

    protected ModalInteractState $interactState;

    protected ModalStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = ModalComponentState::ENABLED;
        $this->interactState = new ModalInteractState();
        $this->stateMachine = new ModalStateMachine();
    }

    public function componentName(): string
    {
        return 'modal';
    }

    public function title(?string $title = null): string|static|null
    {
        if ($title === null) {
            return $this->title;
        }

        $this->title = $title;

        return $this;
    }

    public function content(?string $content = null): string|static|null
    {
        if ($content === null) {
            return $this->content;
        }

        $this->content = $content;

        return $this;
    }

    public function footer(?string $footer = null): string|static|null
    {
        if ($footer === null) {
            return $this->footer;
        }

        $this->footer = $footer;

        return $this;
    }

    public function opened(?bool $opened = null): bool|static
    {
        if ($opened === null) {
            return $this->opened;
        }

        $this->opened = $opened;
        $this->interactState()->opened = $opened;

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

    public function sizePreset(?string $sizePreset = null): string|static|null
    {
        if ($sizePreset === null) {
            return $this->sizePreset;
        }

        $this->sizePreset = $sizePreset;

        return $this;
    }

    public function interactState(?ModalInteractState $state = null): ModalInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(ModalComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(ModalComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(ModalComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(ModalComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(ModalComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(ModalComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(ModalComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(ModalComponentEvent::SHOW);
    }

    public function open(): static
    {
        $this->dispatch(ModalComponentEvent::OPEN);
        $this->opened(true);

        return $this;
    }

    public function close(): static
    {
        $this->dispatch(ModalComponentEvent::CLOSE);
        $this->opened(false);

        return $this;
    }

    public function toggle(): static
    {
        $this->dispatch(ModalComponentEvent::TOGGLE);
        $this->opened(! $this->opened());

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(ModalComponentEvent::RESET);
        $this->opened(false);

        return $this;
    }

    protected function currentState(): ModalComponentState
    {
        if ($this->state instanceof ModalComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return ModalComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de modal inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del modal no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'title' => $this->title(),
            'content' => $this->content(),
            'footer' => $this->footer(),
            'opened' => $this->opened(),
            'dismissible' => $this->dismissible(),
            'size_preset' => $this->sizePreset(),
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
            'content' => $this->content(),
            'footer' => $this->footer(),
            'opened' => $this->opened(),
            'dismissible' => $this->dismissible(),
            'size_preset' => $this->sizePreset(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
