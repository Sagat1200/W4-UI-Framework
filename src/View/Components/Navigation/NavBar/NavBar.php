<?php

namespace W4\UI\Framework\View\Components\Navigation\NavBar;

use W4\UI\Framework\Components\Navigation\NavBar\NavBar as NavBarComponent;
use W4\UI\Framework\Components\Navigation\NavBar\NavBarComponentEvent;
use W4\UI\Framework\Components\Navigation\NavBar\NavBarInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class NavBar extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $brand = null,
        public ?string $brandUrl = null,
        public ?array $items = null,
        public bool $sticky = false,
        public bool $bordered = true,
        public bool $mobileExpanded = false,
        public ?string $position = 'top',
        public string $variant = 'default',
        public string $size = 'md',
        public bool $active = false,
        public bool $disabled = false,
        public bool $hidden = false,
        public bool $focused = false,
        public bool $hovered = false,
        public ?string $ariaLabel = null,
        public ?string $ariaDescribedBy = null,
    ) {
        parent::__construct(
            id: $id,
            name: $name,
            theme: $theme,
            renderer: $renderer,
            componentId: $componentId,
        );
    }

    protected function makeComponent(): ComponentInterface
    {
        $navBar = NavBarComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->sticky($this->sticky)
            ->bordered($this->bordered)
            ->mobileExpanded($this->mobileExpanded);

        if ($this->brand !== null) {
            $navBar->brand($this->brand);
        }

        if ($this->brandUrl !== null) {
            $navBar->brandUrl($this->brandUrl);
        }

        if ($this->items !== null) {
            $navBar->items($this->items);
        }

        if ($this->position !== null) {
            $navBar->position($this->position);
        }

        if ($this->hidden) {
            $navBar->dispatch(NavBarComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $navBar->dispatch(NavBarComponentEvent::DISABLE);
        } elseif ($this->mobileExpanded) {
            $navBar->dispatch(NavBarComponentEvent::EXPAND);
        } elseif ($this->active) {
            $navBar->dispatch(NavBarComponentEvent::ACTIVATE);
        }

        $navBar->interactState(new NavBarInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            mobileExpanded: $this->mobileExpanded,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $navBar->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $navBar->accessibilityState($accessibilityState);
        }

        return $navBar;
    }
}
