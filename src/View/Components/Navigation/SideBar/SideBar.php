<?php

namespace W4\UI\Framework\View\Components\Navigation\SideBar;

use W4\UI\Framework\Components\Navigation\SideBar\SideBar as SideBarComponent;
use W4\UI\Framework\Components\Navigation\SideBar\SideBarComponentEvent;
use W4\UI\Framework\Components\Navigation\SideBar\SideBarInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class SideBar extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $title = null,
        public ?array $items = null,
        public ?string $position = 'left',
        public bool $collapsed = false,
        public bool $overlay = false,
        public bool $sticky = false,
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
        $baseLabel = $this->label ?? $this->title;

        $sideBar = SideBarComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size)
            ->collapsed($this->collapsed)
            ->overlay($this->overlay)
            ->sticky($this->sticky);

        if ($this->title !== null) {
            $sideBar->title($this->title);
        }

        if ($this->items !== null) {
            $sideBar->items($this->items);
        }

        if ($this->position !== null) {
            $sideBar->position($this->position);
        }

        if ($this->hidden) {
            $sideBar->dispatch(SideBarComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $sideBar->dispatch(SideBarComponentEvent::DISABLE);
        } elseif ($this->collapsed) {
            $sideBar->dispatch(SideBarComponentEvent::COLLAPSE);
        } elseif ($this->active) {
            $sideBar->dispatch(SideBarComponentEvent::ACTIVATE);
        }

        $sideBar->interactState(new SideBarInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            expanded: ! $this->collapsed,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $sideBar->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $sideBar->accessibilityState($accessibilityState);
        }

        return $sideBar;
    }
}
