<?php

namespace W4\UI\Framework\Components\FeedBack\Toast;

use InvalidArgumentException;
use W4\UI\Framework\Components\FeedBack\Toast\ToastAccessibilityState;
use W4\UI\Framework\Components\FeedBack\Toast\ToastComponentEvent;
use W4\UI\Framework\Components\FeedBack\Toast\ToastComponentState;
use W4\UI\Framework\Components\FeedBack\Toast\ToastInteractState;
use W4\UI\Framework\Components\FeedBack\Toast\ToastStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Toast extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $title = null;

    protected ?string $message = null;

    protected ?string $icon = null;

    protected bool $dismissible = true;

    protected bool $dismissed = false;

    protected bool $autoDismiss = true;

    protected int $duration = 3000;

    protected string $vertical = 'bottom';

    protected string $horizontal = 'end';

    protected ?string $tone = 'info';

    protected ToastInteractState $interactState;

    protected ToastAccessibilityState $accessibilityState;

    protected ToastStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'info';
        $this->size = 'md';
        $this->state = ToastComponentState::ENABLED;
        $this->interactState = new ToastInteractState();
        $this->accessibilityState = new ToastAccessibilityState();
        $this->stateMachine = new ToastStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'toast';
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
        $this->syncAccessibilityState();

        return $this;
    }

    public function autoDismiss(?bool $autoDismiss = null): bool|static
    {
        if ($autoDismiss === null) {
            return $this->autoDismiss;
        }

        $this->autoDismiss = $autoDismiss;
        $this->syncAccessibilityState();

        return $this;
    }

    public function duration(?int $duration = null): int|static
    {
        if ($duration === null) {
            return $this->duration;
        }

        $this->duration = max(0, $duration);
        $this->syncAccessibilityState();

        return $this;
    }

    public function vertical(?string $vertical = null): string|static
    {
        if ($vertical === null) {
            return $this->vertical;
        }

        $allowed = ['top', 'bottom', 'middle'];
        if (! in_array($vertical, $allowed, true)) {
            throw new InvalidArgumentException('Posición vertical de toast inválida.');
        }

        $this->vertical = $vertical;

        return $this;
    }

    public function horizontal(?string $horizontal = null): string|static
    {
        if ($horizontal === null) {
            return $this->horizontal;
        }

        $allowed = ['start', 'end', 'center'];
        if (! in_array($horizontal, $allowed, true)) {
            throw new InvalidArgumentException('Posición horizontal de toast inválida.');
        }

        $this->horizontal = $horizontal;

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

    public function interactState(?ToastInteractState $state = null): ToastInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?ToastAccessibilityState $state = null): ToastAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(ToastComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(ToastComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(ToastComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(ToastComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(ToastComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(ToastComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(ToastComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(ToastComponentEvent::SHOW);
    }

    public function dismiss(): static
    {
        $this->dispatch(ToastComponentEvent::DISMISS);
        $this->dismissed(true);

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(ToastComponentEvent::RESET);
        $this->dismissed(false);

        return $this;
    }

    protected function currentState(): ToastComponentState
    {
        if ($this->state instanceof ToastComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return ToastComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de toast inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del toast no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'title' => $this->title(),
            'message' => $this->message(),
            'icon' => $this->icon(),
            'dismissible' => $this->dismissible(),
            'dismissed' => $this->dismissed(),
            'auto_dismiss' => $this->autoDismiss(),
            'duration' => $this->duration(),
            'vertical' => $this->vertical(),
            'horizontal' => $this->horizontal(),
            'top' => $this->vertical() === 'top',
            'bottom' => $this->vertical() === 'bottom',
            'middle' => $this->vertical() === 'middle',
            'start' => $this->horizontal() === 'start',
            'end' => $this->horizontal() === 'end',
            'center' => $this->horizontal() === 'center',
            'tone' => $this->tone(),
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
            'title' => $this->title(),
            'message' => $this->message(),
            'icon' => $this->icon(),
            'dismissible' => $this->dismissible(),
            'dismissed' => $this->dismissed(),
            'auto_dismiss' => $this->autoDismiss(),
            'duration' => $this->duration(),
            'vertical' => $this->vertical(),
            'horizontal' => $this->horizontal(),
            'top' => $this->vertical() === 'top',
            'bottom' => $this->vertical() === 'bottom',
            'middle' => $this->vertical() === 'middle',
            'start' => $this->horizontal() === 'start',
            'end' => $this->horizontal() === 'end',
            'center' => $this->horizontal() === 'center',
            'tone' => $this->tone(),
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

        $this->accessibilityState->ariaHidden = $this->dismissed() || $stateValue === ToastComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === ToastComponentState::ACTIVE->value;

        if ($this->autoDismiss() && $this->duration() > 0) {
            $this->attribute('data-w4-duration', (string) $this->duration());
        } else {
            $this->forgetAttribute('data-w4-duration');
        }

        $this->attributes($this->accessibilityState->toAttributes());
    }
}
