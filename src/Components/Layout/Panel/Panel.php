<?php

namespace W4\UiFramework\Components\Layout\Panel;

use InvalidArgumentException;
use W4\UiFramework\Components\Layout\Panel\PanelAccessibilityState;
use W4\UiFramework\Components\Layout\Panel\PanelComponentEvent;
use W4\UiFramework\Components\Layout\Panel\PanelComponentState;
use W4\UiFramework\Components\Layout\Panel\PanelInteractState;
use W4\UiFramework\Components\Layout\Panel\PanelStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Panel extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $title = null;

    protected ?string $body = null;

    protected ?string $footer = null;

    protected bool $collapsible = false;

    protected bool $bordered = true;

    protected bool $padded = true;

    protected ?string $tone = 'default';

    protected PanelInteractState $interactState;

    protected PanelAccessibilityState $accessibilityState;

    protected PanelStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = PanelComponentState::ENABLED;
        $this->interactState = new PanelInteractState();
        $this->accessibilityState = new PanelAccessibilityState();
        $this->stateMachine = new PanelStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'panel';
    }

    public function title(?string $title = null): string|static|null
    {
        if ($title === null) {
            return $this->title;
        }

        $this->title = $title;

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

    public function collapsible(?bool $collapsible = null): bool|static
    {
        if ($collapsible === null) {
            return $this->collapsible;
        }

        $this->collapsible = $collapsible;

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

    public function tone(?string $tone = null): string|static|null
    {
        if ($tone === null) {
            return $this->tone;
        }

        $this->tone = $tone;

        return $this;
    }

    public function interactState(?PanelInteractState $state = null): PanelInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?PanelAccessibilityState $state = null): PanelAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(PanelComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(PanelComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(PanelComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(PanelComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(PanelComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(PanelComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(PanelComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(PanelComponentEvent::SHOW);
    }

    public function collapse(): static
    {
        if (! $this->collapsible()) {
            $this->collapsible(true);
        }

        $this->dispatch(PanelComponentEvent::COLLAPSE);
        $this->interactState()->expanded = false;

        return $this;
    }

    public function expand(): static
    {
        $this->dispatch(PanelComponentEvent::EXPAND);
        $this->interactState()->expanded = true;

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(PanelComponentEvent::RESET);
        $this->interactState()->expanded = true;

        return $this;
    }

    protected function currentState(): PanelComponentState
    {
        if ($this->state instanceof PanelComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return PanelComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de panel inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del panel no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'title' => $this->title(),
            'body' => $this->body(),
            'footer' => $this->footer(),
            'collapsible' => $this->collapsible(),
            'bordered' => $this->bordered(),
            'padded' => $this->padded(),
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
            'body' => $this->body(),
            'footer' => $this->footer(),
            'collapsible' => $this->collapsible(),
            'bordered' => $this->bordered(),
            'padded' => $this->padded(),
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
        $isExpanded = $this->interactState()->expanded;
        $this->accessibilityState->ariaHidden = $stateValue === PanelComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === PanelComponentState::ACTIVE->value;
        $this->accessibilityState->ariaExpanded = $this->collapsible() ? ($isExpanded ? 'true' : 'false') : null;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}
