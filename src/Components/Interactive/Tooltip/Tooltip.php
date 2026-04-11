<?php

namespace W4\UiFramework\Components\Interactive\Tooltip;

use InvalidArgumentException;
use W4\UiFramework\Components\Interactive\Tooltip\TooltipAccessibilityState;
use W4\UiFramework\Components\Interactive\Tooltip\TooltipComponentEvent;
use W4\UiFramework\Components\Interactive\Tooltip\TooltipComponentState;
use W4\UiFramework\Components\Interactive\Tooltip\TooltipInteractState;
use W4\UiFramework\Components\Interactive\Tooltip\TooltipStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Tooltip extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $text = null;

    protected ?string $placement = 'top';

    protected ?string $trigger = 'hover';

    protected bool $opened = false;

    protected ?int $delay = 0;

    protected bool $arrow = true;

    protected TooltipInteractState $interactState;

    protected TooltipAccessibilityState $accessibilityState;

    protected TooltipStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = TooltipComponentState::ENABLED;
        $this->interactState = new TooltipInteractState();
        $this->accessibilityState = new TooltipAccessibilityState();
        $this->stateMachine = new TooltipStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'tooltip';
    }

    public function text(?string $text = null): string|static|null
    {
        if ($text === null) {
            return $this->text;
        }

        $this->text = $text;

        return $this;
    }

    public function placement(?string $placement = null): string|static|null
    {
        if ($placement === null) {
            return $this->placement;
        }

        $this->placement = $placement;

        return $this;
    }

    public function trigger(?string $trigger = null): string|static|null
    {
        if ($trigger === null) {
            return $this->trigger;
        }

        $this->trigger = $trigger;

        return $this;
    }

    public function opened(?bool $opened = null): bool|static
    {
        if ($opened === null) {
            return $this->opened;
        }

        $this->opened = $opened;
        $this->interactState()->opened = $opened;
        $this->syncAccessibilityState();

        return $this;
    }

    public function delay(?int $delay = null): int|static|null
    {
        if ($delay === null) {
            return $this->delay;
        }

        $this->delay = $delay;

        return $this;
    }

    public function arrow(?bool $arrow = null): bool|static
    {
        if ($arrow === null) {
            return $this->arrow;
        }

        $this->arrow = $arrow;

        return $this;
    }

    public function interactState(?TooltipInteractState $state = null): TooltipInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?TooltipAccessibilityState $state = null): TooltipAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(TooltipComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(TooltipComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(TooltipComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(TooltipComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(TooltipComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(TooltipComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(TooltipComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(TooltipComponentEvent::SHOW);
    }

    public function open(): static
    {
        $this->dispatch(TooltipComponentEvent::OPEN);
        $this->opened(true);

        return $this;
    }

    public function close(): static
    {
        $this->dispatch(TooltipComponentEvent::CLOSE);
        $this->opened(false);

        return $this;
    }

    public function toggle(): static
    {
        $this->dispatch(TooltipComponentEvent::TOGGLE);
        $this->opened(! $this->opened());

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(TooltipComponentEvent::RESET);
        $this->opened(false);

        return $this;
    }

    protected function currentState(): TooltipComponentState
    {
        if ($this->state instanceof TooltipComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return TooltipComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de tooltip inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del tooltip no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'text' => $this->text(),
            'placement' => $this->placement(),
            'trigger' => $this->trigger(),
            'opened' => $this->opened(),
            'delay' => $this->delay(),
            'arrow' => $this->arrow(),
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
            'placement' => $this->placement(),
            'trigger' => $this->trigger(),
            'opened' => $this->opened(),
            'delay' => $this->delay(),
            'arrow' => $this->arrow(),
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

        $isOpen = $this->opened() || $stateValue === TooltipComponentState::OPEN->value;
        $this->accessibilityState->ariaHidden = ! $isOpen || $stateValue === TooltipComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === TooltipComponentState::ACTIVE->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
