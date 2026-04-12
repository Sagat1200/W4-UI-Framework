<?php

namespace W4\UI\Framework\Components\FeedBack\Badge;

use InvalidArgumentException;
use W4\UI\Framework\Components\FeedBack\Badge\BadgeAccessibilityState;
use W4\UI\Framework\Components\FeedBack\Badge\BadgeComponentEvent;
use W4\UI\Framework\Components\FeedBack\Badge\BadgeComponentState;
use W4\UI\Framework\Components\FeedBack\Badge\BadgeInteractState;
use W4\UI\Framework\Components\FeedBack\Badge\BadgeStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Badge extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $text = null;

    protected ?string $icon = null;

    protected ?string $tone = 'neutral';

    protected bool $pill = false;

    protected bool $outlined = false;

    protected bool $highlighted = false;

    protected BadgeInteractState $interactState;

    protected BadgeAccessibilityState $accessibilityState;

    protected BadgeStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = BadgeComponentState::ENABLED;
        $this->interactState = new BadgeInteractState();
        $this->accessibilityState = new BadgeAccessibilityState();
        $this->stateMachine = new BadgeStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'badge';
    }

    public function text(?string $text = null): string|static|null
    {
        if ($text === null) {
            return $this->text;
        }

        $this->text = $text;

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

    public function tone(?string $tone = null): string|static|null
    {
        if ($tone === null) {
            return $this->tone;
        }

        $this->tone = $tone;

        return $this;
    }

    public function pill(?bool $pill = null): bool|static
    {
        if ($pill === null) {
            return $this->pill;
        }

        $this->pill = $pill;

        return $this;
    }

    public function outlined(?bool $outlined = null): bool|static
    {
        if ($outlined === null) {
            return $this->outlined;
        }

        $this->outlined = $outlined;

        return $this;
    }

    public function highlighted(?bool $highlighted = null): bool|static
    {
        if ($highlighted === null) {
            return $this->highlighted;
        }

        $this->highlighted = $highlighted;
        $this->interactState()->highlighted = $highlighted;
        $this->syncAccessibilityState();

        return $this;
    }

    public function interactState(?BadgeInteractState $state = null): BadgeInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?BadgeAccessibilityState $state = null): BadgeAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(BadgeComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(BadgeComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(BadgeComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(BadgeComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(BadgeComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(BadgeComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(BadgeComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(BadgeComponentEvent::SHOW);
    }

    public function highlight(): static
    {
        $this->dispatch(BadgeComponentEvent::HIGHLIGHT);
        $this->highlighted(true);

        return $this;
    }

    public function normalize(): static
    {
        $this->dispatch(BadgeComponentEvent::NORMALIZE);
        $this->highlighted(false);

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(BadgeComponentEvent::RESET);
        $this->highlighted(false);

        return $this;
    }

    protected function currentState(): BadgeComponentState
    {
        if ($this->state instanceof BadgeComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return BadgeComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de badge inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del badge no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'text' => $this->text(),
            'icon' => $this->icon(),
            'tone' => $this->tone(),
            'pill' => $this->pill(),
            'outlined' => $this->outlined(),
            'highlighted' => $this->highlighted(),
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
            'icon' => $this->icon(),
            'tone' => $this->tone(),
            'pill' => $this->pill(),
            'outlined' => $this->outlined(),
            'highlighted' => $this->highlighted(),
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

        $this->accessibilityState->ariaHidden = $stateValue === BadgeComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === BadgeComponentState::ACTIVE->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
