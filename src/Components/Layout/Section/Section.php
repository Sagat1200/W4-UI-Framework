<?php

namespace W4\UiFramework\Components\Layout\Section;

use InvalidArgumentException;
use W4\UiFramework\Components\Layout\Section\SectionAccessibilityState;
use W4\UiFramework\Components\Layout\Section\SectionComponentEvent;
use W4\UiFramework\Components\Layout\Section\SectionComponentState;
use W4\UiFramework\Components\Layout\Section\SectionInteractState;
use W4\UiFramework\Components\Layout\Section\SectionStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Section extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $title = null;

    protected ?string $subtitle = null;

    protected ?string $content = null;

    protected bool $collapsible = false;

    protected bool $bordered = false;

    protected bool $padded = true;

    protected ?string $spacing = 'md';

    protected SectionInteractState $interactState;

    protected SectionAccessibilityState $accessibilityState;

    protected SectionStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = SectionComponentState::ENABLED;
        $this->interactState = new SectionInteractState();
        $this->accessibilityState = new SectionAccessibilityState();
        $this->stateMachine = new SectionStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'section';
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

    public function content(?string $content = null): string|static|null
    {
        if ($content === null) {
            return $this->content;
        }

        $this->content = $content;

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

    public function spacing(?string $spacing = null): string|static|null
    {
        if ($spacing === null) {
            return $this->spacing;
        }

        $this->spacing = $spacing;

        return $this;
    }

    public function interactState(?SectionInteractState $state = null): SectionInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?SectionAccessibilityState $state = null): SectionAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(SectionComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(SectionComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(SectionComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(SectionComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(SectionComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(SectionComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(SectionComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(SectionComponentEvent::SHOW);
    }

    public function collapse(): static
    {
        if (! $this->collapsible()) {
            $this->collapsible(true);
        }

        $this->dispatch(SectionComponentEvent::COLLAPSE);
        $this->interactState()->expanded = false;

        return $this;
    }

    public function expand(): static
    {
        $this->dispatch(SectionComponentEvent::EXPAND);
        $this->interactState()->expanded = true;

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(SectionComponentEvent::RESET);
        $this->interactState()->expanded = true;

        return $this;
    }

    protected function currentState(): SectionComponentState
    {
        if ($this->state instanceof SectionComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return SectionComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de section inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del section no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'title' => $this->title(),
            'subtitle' => $this->subtitle(),
            'content' => $this->content(),
            'collapsible' => $this->collapsible(),
            'bordered' => $this->bordered(),
            'padded' => $this->padded(),
            'spacing' => $this->spacing(),
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
            'subtitle' => $this->subtitle(),
            'content' => $this->content(),
            'collapsible' => $this->collapsible(),
            'bordered' => $this->bordered(),
            'padded' => $this->padded(),
            'spacing' => $this->spacing(),
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
        $this->accessibilityState->ariaHidden = $stateValue === SectionComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === SectionComponentState::ACTIVE->value;
        $this->accessibilityState->ariaExpanded = $this->collapsible() ? ($isExpanded ? 'true' : 'false') : null;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}