<?php

namespace W4\UI\Framework\Components\UI\Link;

use InvalidArgumentException;
use W4\UI\Framework\Components\UI\Link\LinkAccessibilityState;
use W4\UI\Framework\Components\UI\Link\LinkComponentEvent;
use W4\UI\Framework\Components\UI\Link\LinkComponentState;
use W4\UI\Framework\Components\UI\Link\LinkInteractState;
use W4\UI\Framework\Components\UI\Link\LinkStateMachine;
use W4\UI\Framework\Core\BaseComponent;
use W4\UI\Framework\Support\Traits\InteractsWithSize;
use W4\UI\Framework\Support\Traits\InteractsWithState;
use W4\UI\Framework\Support\Traits\InteractsWithVariant;

class Link extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $text = null;
    protected ?string $href = null;
    protected ?string $target = null;
    protected ?string $rel = null;
    protected LinkInteractState $interactState;
    protected LinkAccessibilityState $accessibilityState;
    protected LinkStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'neutral';
        $this->size = 'md';
        $this->state = LinkComponentState::ENABLED;
        $this->interactState = new LinkInteractState();
        $this->accessibilityState = new LinkAccessibilityState();
        $this->stateMachine = new LinkStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'link';
    }

    public function text(?string $text = null): string|static|null
    {
        if ($text === null) {
            return $this->text;
        }

        $this->text = $text;

        return $this;
    }

    public function href(?string $href = null): string|static|null
    {
        if ($href === null) {
            return $this->href;
        }

        $this->href = trim($href);

        return $this;
    }

    public function target(?string $target = null): string|static|null
    {
        if ($target === null) {
            return $this->target;
        }

        $this->target = trim($target);

        return $this;
    }

    public function rel(?string $rel = null): string|static|null
    {
        if ($rel === null) {
            return $this->rel;
        }

        $this->rel = trim($rel);

        return $this;
    }

    public function interactState(?LinkInteractState $state = null): LinkInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?LinkAccessibilityState $state = null): LinkAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(LinkComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(LinkComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(LinkComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(LinkComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(LinkComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(LinkComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(LinkComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(LinkComponentEvent::SHOW);
    }

    public function resetState(): static
    {
        return $this->dispatch(LinkComponentEvent::RESET);
    }

    protected function currentState(): LinkComponentState
    {
        if ($this->state instanceof LinkComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return LinkComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de link inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del link no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'text' => $this->text(),
            'href' => $this->href(),
            'target' => $this->target(),
            'rel' => $this->rel(),
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
            'href' => $this->href(),
            'target' => $this->target(),
            'rel' => $this->rel(),
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

        $this->accessibilityState->ariaDisabled = $stateValue === LinkComponentState::DISABLED->value ? 'true' : 'false';
        $this->accessibilityState->ariaHidden = $stateValue === LinkComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === LinkComponentState::ACTIVE->value;
        $this->attributes($this->accessibilityState->toAttributes());
    }
}