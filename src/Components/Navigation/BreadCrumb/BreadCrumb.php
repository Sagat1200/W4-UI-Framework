<?php

namespace W4\UiFramework\Components\Navigation\BreadCrumb;

use InvalidArgumentException;
use W4\UiFramework\Components\Navigation\BreadCrumb\BreadCrumbAccessibilityState;
use W4\UiFramework\Components\Navigation\BreadCrumb\BreadCrumbComponentEvent;
use W4\UiFramework\Components\Navigation\BreadCrumb\BreadCrumbComponentState;
use W4\UiFramework\Components\Navigation\BreadCrumb\BreadCrumbInteractState;
use W4\UiFramework\Components\Navigation\BreadCrumb\BreadCrumbStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class BreadCrumb extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?array $items = null;

    protected ?string $separator = '/';

    protected ?string $homeLabel = 'Inicio';

    protected ?string $homeUrl = '/';

    protected bool $collapsed = false;

    protected int $maxVisibleItems = 5;

    protected BreadCrumbInteractState $interactState;

    protected BreadCrumbAccessibilityState $accessibilityState;

    protected BreadCrumbStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = BreadCrumbComponentState::ENABLED;
        $this->interactState = new BreadCrumbInteractState();
        $this->accessibilityState = new BreadCrumbAccessibilityState();
        $this->stateMachine = new BreadCrumbStateMachine();
        $this->syncAccessibilityState();
    }

    public function componentName(): string
    {
        return 'breadcrumb';
    }

    public function items(?array $items = null): array|static|null
    {
        if ($items === null) {
            return $this->items;
        }

        $this->items = $items;

        return $this;
    }

    public function addItem(array $item): static
    {
        $items = $this->items ?? [];
        $items[] = $item;
        $this->items = $items;

        return $this;
    }

    public function separator(?string $separator = null): string|static|null
    {
        if ($separator === null) {
            return $this->separator;
        }

        $this->separator = $separator;

        return $this;
    }

    public function homeLabel(?string $homeLabel = null): string|static|null
    {
        if ($homeLabel === null) {
            return $this->homeLabel;
        }

        $this->homeLabel = $homeLabel;

        return $this;
    }

    public function homeUrl(?string $homeUrl = null): string|static|null
    {
        if ($homeUrl === null) {
            return $this->homeUrl;
        }

        $this->homeUrl = $homeUrl;

        return $this;
    }

    public function collapsed(?bool $collapsed = null): bool|static
    {
        if ($collapsed === null) {
            return $this->collapsed;
        }

        $this->collapsed = $collapsed;
        $this->interactState()->collapsed = $collapsed;
        $this->syncAccessibilityState();

        return $this;
    }

    public function maxVisibleItems(?int $maxVisibleItems = null): int|static
    {
        if ($maxVisibleItems === null) {
            return $this->maxVisibleItems;
        }

        $this->maxVisibleItems = $maxVisibleItems;

        return $this;
    }

    public function interactState(?BreadCrumbInteractState $state = null): BreadCrumbInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function accessibilityState(?BreadCrumbAccessibilityState $state = null): BreadCrumbAccessibilityState|static
    {
        if ($state === null) {
            return $this->accessibilityState;
        }

        $this->accessibilityState = $state;
        $this->attributes($this->accessibilityState->toAttributes());

        return $this;
    }

    public function can(BreadCrumbComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(BreadCrumbComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));
        $this->syncAccessibilityState();

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(BreadCrumbComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(BreadCrumbComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(BreadCrumbComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(BreadCrumbComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(BreadCrumbComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(BreadCrumbComponentEvent::SHOW);
    }

    public function expand(): static
    {
        $this->dispatch(BreadCrumbComponentEvent::EXPAND);
        $this->collapsed(false);

        return $this;
    }

    public function collapse(): static
    {
        $this->dispatch(BreadCrumbComponentEvent::COLLAPSE);
        $this->collapsed(true);

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(BreadCrumbComponentEvent::RESET);
        $this->collapsed(false);

        return $this;
    }

    protected function currentState(): BreadCrumbComponentState
    {
        if ($this->state instanceof BreadCrumbComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return BreadCrumbComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de breadcrumb inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del breadcrumb no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'items' => $this->items(),
            'separator' => $this->separator(),
            'home_label' => $this->homeLabel(),
            'home_url' => $this->homeUrl(),
            'collapsed' => $this->collapsed(),
            'max_visible_items' => $this->maxVisibleItems(),
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
            'items' => $this->items(),
            'separator' => $this->separator(),
            'home_label' => $this->homeLabel(),
            'home_url' => $this->homeUrl(),
            'collapsed' => $this->collapsed(),
            'max_visible_items' => $this->maxVisibleItems(),
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

        $this->accessibilityState->ariaHidden = $stateValue === BreadCrumbComponentState::HIDDEN->value;
        $this->accessibilityState->ariaBusy = $stateValue === BreadCrumbComponentState::ACTIVE->value;
        $this->accessibilityState->ariaExpanded = $this->collapsed() ? 'false' : 'true';
        $this->attributes($this->accessibilityState->toAttributes());
    }
}