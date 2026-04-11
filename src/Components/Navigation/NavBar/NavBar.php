<?php

namespace W4\UiFramework\Components\Navigation\NavBar;

use InvalidArgumentException;
use W4\UiFramework\Components\Navigation\NavBar\NavBarComponentEvent;
use W4\UiFramework\Components\Navigation\NavBar\NavBarComponentState;
use W4\UiFramework\Components\Navigation\NavBar\NavBarInteractState;
use W4\UiFramework\Components\Navigation\NavBar\NavBarStateMachine;
use W4\UiFramework\Core\BaseComponent;
use W4\UiFramework\Support\Traits\InteractsWithSize;
use W4\UiFramework\Support\Traits\InteractsWithState;
use W4\UiFramework\Support\Traits\InteractsWithVariant;

class NavBar extends BaseComponent
{
    use InteractsWithVariant;
    use InteractsWithSize;
    use InteractsWithState;

    protected ?string $brand = null;

    protected ?string $brandUrl = null;

    protected ?array $items = null;

    protected bool $sticky = false;

    protected bool $bordered = true;

    protected bool $mobileExpanded = false;

    protected ?string $position = 'top';

    protected NavBarInteractState $interactState;

    protected NavBarStateMachine $stateMachine;

    public function __construct()
    {
        parent::__construct();

        $this->variant = 'default';
        $this->size = 'md';
        $this->state = NavBarComponentState::ENABLED;
        $this->interactState = new NavBarInteractState();
        $this->stateMachine = new NavBarStateMachine();
    }

    public function componentName(): string
    {
        return 'navbar';
    }

    public function brand(?string $brand = null): string|static|null
    {
        if ($brand === null) {
            return $this->brand;
        }

        $this->brand = $brand;

        return $this;
    }

    public function brandUrl(?string $brandUrl = null): string|static|null
    {
        if ($brandUrl === null) {
            return $this->brandUrl;
        }

        $this->brandUrl = $brandUrl;

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

    public function sticky(?bool $sticky = null): bool|static
    {
        if ($sticky === null) {
            return $this->sticky;
        }

        $this->sticky = $sticky;

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

    public function mobileExpanded(?bool $mobileExpanded = null): bool|static
    {
        if ($mobileExpanded === null) {
            return $this->mobileExpanded;
        }

        $this->mobileExpanded = $mobileExpanded;
        $this->interactState()->mobileExpanded = $mobileExpanded;

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

    public function interactState(?NavBarInteractState $state = null): NavBarInteractState|static
    {
        if ($state === null) {
            return $this->interactState;
        }

        $this->interactState = $state;

        return $this;
    }

    public function can(NavBarComponentEvent $event): bool
    {
        return $this->stateMachine->canTransition($this->currentState(), $event);
    }

    public function dispatch(NavBarComponentEvent $event): static
    {
        $this->state($this->stateMachine->transition($this->currentState(), $event));

        return $this;
    }

    public function activate(): static
    {
        return $this->dispatch(NavBarComponentEvent::ACTIVATE);
    }

    public function deactivate(): static
    {
        return $this->dispatch(NavBarComponentEvent::DEACTIVATE);
    }

    public function disable(): static
    {
        return $this->dispatch(NavBarComponentEvent::DISABLE);
    }

    public function enable(): static
    {
        return $this->dispatch(NavBarComponentEvent::ENABLE);
    }

    public function hide(): static
    {
        return $this->dispatch(NavBarComponentEvent::HIDE);
    }

    public function show(): static
    {
        return $this->dispatch(NavBarComponentEvent::SHOW);
    }

    public function expand(): static
    {
        $this->dispatch(NavBarComponentEvent::EXPAND);
        $this->mobileExpanded(true);

        return $this;
    }

    public function collapse(): static
    {
        $this->dispatch(NavBarComponentEvent::COLLAPSE);
        $this->mobileExpanded(false);

        return $this;
    }

    public function toggleMobile(): static
    {
        $this->dispatch(NavBarComponentEvent::TOGGLE_MOBILE);
        $this->mobileExpanded(! $this->mobileExpanded());

        return $this;
    }

    public function resetState(): static
    {
        $this->dispatch(NavBarComponentEvent::RESET);
        $this->mobileExpanded(false);

        return $this;
    }

    protected function currentState(): NavBarComponentState
    {
        if ($this->state instanceof NavBarComponentState) {
            return $this->state;
        }

        if (is_string($this->state)) {
            try {
                return NavBarComponentState::from($this->state);
            } catch (\ValueError) {
                throw new InvalidArgumentException('Estado de navbar inválido [' . (string) $this->state . ']');
            }
        }

        throw new InvalidArgumentException('El estado actual del navbar no es válido.');
    }

    public function toThemeContext(): array
    {
        return array_merge(parent::toThemeContext(), [
            'brand' => $this->brand(),
            'brand_url' => $this->brandUrl(),
            'items' => $this->items(),
            'sticky' => $this->sticky(),
            'bordered' => $this->bordered(),
            'mobile_expanded' => $this->mobileExpanded(),
            'position' => $this->position(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'brand' => $this->brand(),
            'brand_url' => $this->brandUrl(),
            'items' => $this->items(),
            'sticky' => $this->sticky(),
            'bordered' => $this->bordered(),
            'mobile_expanded' => $this->mobileExpanded(),
            'position' => $this->position(),
            'variant' => $this->variant(),
            'size' => $this->size(),
            'state' => $this->stateValue(),
            'interact_state' => $this->interactState()->toArray(),
        ]);
    }
}
