<?php

namespace W4\UiFramework\Components\Layout\Card;

use InvalidArgumentException;
use W4\UiFramework\Components\Layout\Card\CardComponentEvent;
use W4\UiFramework\Components\Layout\Card\CardComponentState;
use W4\UiFramework\Components\Layout\Card\CardInteractState;
use W4\UiFramework\Components\Layout\Card\CardStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Card extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $title = null;

    protected ?string $subtitle = null;

    protected ?string $body = null;

    protected ?string $footer = null;

    protected bool $elevated = false;

    protected bool $bordered = true;

    protected bool $padded = true;

    protected bool $collapsible = false;

    protected CardInteractState $interactState;

    protected CardStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = CardComponentState::ENABLED;
        $this->interactState = new CardInteractState();
        $this->stateMachine = new CardStateMachine();
    }

    public function componentName(): string
    {
        return 'card';
    }

    public function title(?string $title = null): string|static|null
    {
        if ($title === null) {
            return $this->title;
        }

        $this->title = $title;

        return $this;
    }

    public function subtitle(?string $subtitle = null): string|static|null
    {
        if ($subtitle === null) {
            return $this->subtitle;
        }

        $this->subtitle = $subtitle;

        return $this;
    }

    public function body(?string $body = null): string|static|null
    {
        if ($body === null) {
            return $this->body;
        }

        $this->body = $body;

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

    public function elevated(?bool $elevated = null): bool|static
    {
        if ($elevated === null) {
            return $this->elevated;
        }

        $this->elevated = $elevated;

        return $this;
    }

    public function bordered(?bool $bordered = null): bool|static
    {
        if ($bordered === null) {
            return $this->bordered;
        }

        $this->bordered = $bordered;

        return $this;
    }

    public function padded(?bool $padded = null): bool|static
    {
        if ($padded === null) {
            return $this->padded;
        }

        $this->padded = $padded;

        return $this;
    }

    public function collapsible(?bool $collapsible = null): bool|static
    {
        if ($collapsible === null) {
            return $this->collapsible;
        }

        $this->collapsible = $collapsible;

        return $this;
    }

    public function interactState(?CardInteractState $state = null): CardInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(CardComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(CardComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(CardComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(CardComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(CardComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(CardComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(CardComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(CardComponentEvent::SHOW);
    }

    public function collapse(): static
    {
        if (! $this->collapsible()) {
            $this->collapsible(true);
        }

        $this->dispatch(CardComponentEvent::COLLAPSE);
        $this->interactState()->expanded = false;

        return $this;
    }

    public function expand(): static
    {
        $this->dispatch(CardComponentEvent::EXPAND);
        $this->interactState()->expanded = true;

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(CardComponentEvent::RESET);
        $this->interactState()->expanded = true;

        return $this;
    }

    protected function currentState(): CardComponentState
    {
        if ($this->state instanceof CardComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return CardComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de card inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del card no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'title' => $this->title(),
            'subtitle' => $this->subtitle(),
            'body' => $this->body(),
            'footer' => $this->footer(),
            'elevated' => $this->elevated(),
            'bordered' => $this->bordered(),
            'padded' => $this->padded(),
            'collapsible' => $this->collapsible(),
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
            'subtitle' => $this->subtitle(),
            'body' => $this->body(),
            'footer' => $this->footer(),
            'elevated' => $this->elevated(),
            'bordered' => $this->bordered(),
            'padded' => $this->padded(),
            'collapsible' => $this->collapsible(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
