<?php

namespace W4\UiFramework\Components\Navigation\SideBar;

use InvalidArgumentException;
use W4\UiFramework\Components\Navigation\SideBar\SideBarComponentEvent;
use W4\UiFramework\Components\Navigation\SideBar\SideBarComponentState;
use W4\UiFramework\Components\Navigation\SideBar\SideBarInteractState;
use W4\UiFramework\Components\Navigation\SideBar\SideBarStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class SideBar extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $title = null;

    protected ?array $items = null;

    protected ?string $position = 'left';

    protected bool $collapsed = false;

    protected bool $overlay = false;

    protected bool $sticky = false;

    protected SideBarInteractState $interactState;

    protected SideBarStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = SideBarComponentState::ENABLED;
        $this->interactState = new SideBarInteractState();
        $this->stateMachine = new SideBarStateMachine();
    }

    public function componentName(): string
    {
        return 'sidebar';
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

    public function position(?string $position = null): string|static|null
    {
        if ($position === null) {
            return $this->position;
        }

        $this->position = $position;

        return $this;
    }

    public function collapsed(?bool $collapsed = null): bool|static
    {
        if ($collapsed === null) {
            return $this->collapsed;
        }

        $this->collapsed = $collapsed;
        $this->interactState()->expanded = ! $collapsed;

        return $this;
    }

    public function overlay(?bool $overlay = null): bool|static
    {
        if ($overlay === null) {
            return $this->overlay;
        }

        $this->overlay = $overlay;

        return $this;
    }

    public function sticky(?bool $sticky = null): bool|static
    {
        if ($sticky === null) {
            return $this->sticky;
        }

        $this->sticky = $sticky;

        return $this;
    }

    public function interactState(?SideBarInteractState $state = null): SideBarInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(SideBarComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(SideBarComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(SideBarComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(SideBarComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(SideBarComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(SideBarComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(SideBarComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(SideBarComponentEvent::SHOW);
    }

    public function expand(): static
    {
        $this->dispatch(SideBarComponentEvent::EXPAND);
        $this->collapsed(false);

        return $this;
    }

    public function collapse(): static
    {
        $this->dispatch(SideBarComponentEvent::COLLAPSE);
        $this->collapsed(true);

        return $this;
    }

    public function toggle(): static
    {
        $this->dispatch(SideBarComponentEvent::TOGGLE);
        $this->collapsed(! $this->collapsed());

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(SideBarComponentEvent::RESET);
        $this->collapsed(false);

        return $this;
    }

    protected function currentState(): SideBarComponentState
    {
        if ($this->state instanceof SideBarComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return SideBarComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de sidebar inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del sidebar no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'title' => $this->title(),
            'items' => $this->items(),
            'position' => $this->position(),
            'collapsed' => $this->collapsed(),
            'overlay' => $this->overlay(),
            'sticky' => $this->sticky(),
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
            'position' => $this->position(),
            'collapsed' => $this->collapsed(),
            'overlay' => $this->overlay(),
            'sticky' => $this->sticky(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
