<?php

namespace W4\UiFramework\Components\Navigation\Menu;

use InvalidArgumentException;
use W4\UiFramework\Components\Navigation\Menu\MenuComponentEvent;
use W4\UiFramework\Components\Navigation\Menu\MenuComponentState;
use W4\UiFramework\Components\Navigation\Menu\MenuInteractState;
use W4\UiFramework\Components\Navigation\Menu\MenuStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class Menu extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $title = null;

    protected ?array $items = null;

    protected ?string $orientation = 'vertical';

    protected bool $opened = false;

    protected bool $collapsible = true;

    protected ?string $trigger = 'click';

    protected MenuInteractState $interactState;

    protected MenuStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = MenuComponentState::ENABLED;
        $this->interactState = new MenuInteractState();
        $this->stateMachine = new MenuStateMachine();
    }

    public function componentName(): string
    {
        return 'menu';
    }

    public function title(?string $title = null): string|static|null
    {
        if ($title === null) {
            return $this->title;
        }

        $this->title = $title;

        return $this;
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

    public function orientation(?string $orientation = null): string|static|null
    {
        if ($orientation === null) {
            return $this->orientation;
        }

        $this->orientation = $orientation;

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

    public function collapsible(?bool $collapsible = null): bool|static
    {
        if ($collapsible === null) {
            return $this->collapsible;
        }

        $this->collapsible = $collapsible;

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

    public function interactState(?MenuInteractState $state = null): MenuInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(MenuComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(MenuComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(MenuComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(MenuComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(MenuComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(MenuComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(MenuComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(MenuComponentEvent::SHOW);
    }

    public function open(): static
    {
        $this->dispatch(MenuComponentEvent::OPEN);
        $this->opened(true);

        return $this;
    }

    public function close(): static
    {
        $this->dispatch(MenuComponentEvent::CLOSE);
        $this->opened(false);

        return $this;
    }

    public function toggle(): static
    {
        $this->dispatch(MenuComponentEvent::TOGGLE);
        $this->opened(! $this->opened());

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(MenuComponentEvent::RESET);
        $this->opened(false);

        return $this;
    }

    protected function currentState(): MenuComponentState
    {
        if ($this->state instanceof MenuComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return MenuComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de menu inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del menu no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'title' => $this->title(),
            'items' => $this->items(),
            'orientation' => $this->orientation(),
            'opened' => $this->opened(),
            'collapsible' => $this->collapsible(),
            'trigger' => $this->trigger(),
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
            'items' => $this->items(),
            'orientation' => $this->orientation(),
            'opened' => $this->opened(),
            'collapsible' => $this->collapsible(),
            'trigger' => $this->trigger(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
