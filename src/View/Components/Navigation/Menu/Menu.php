<?php

namespace W4\UI\Framework\View\Components\Navigation\Menu;

use W4\UI\Framework\Components\Navigation\Menu\Menu as MenuComponent;
use W4\UI\Framework\Components\Navigation\Menu\MenuComponentEvent;
use W4\UI\Framework\Components\Navigation\Menu\MenuInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Menu extends BaseW4BladeComponent
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
        public ?string $orientation = 'vertical',
        public bool $opened = false,
        public bool $collapsible = true,
        public ?string $trigger = 'click',
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

        $menu = MenuComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size)
            ->opened($this->opened)
            ->collapsible($this->collapsible);

        if ($this->title !== null) {
            $menu->title($this->title);
        }

        if ($this->items !== null) {
            $menu->items($this->items);
        }

        if ($this->orientation !== null) {
            $menu->orientation($this->orientation);
        }

        if ($this->trigger !== null) {
            $menu->trigger($this->trigger);
        }

        if ($this->hidden) {
            $menu->dispatch(MenuComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $menu->dispatch(MenuComponentEvent::DISABLE);
        } elseif ($this->opened) {
            $menu->dispatch(MenuComponentEvent::OPEN);
        } elseif ($this->active) {
            $menu->dispatch(MenuComponentEvent::ACTIVATE);
        }

        $menu->interactState(new MenuInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            opened: $this->opened,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $menu->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $menu->accessibilityState($accessibilityState);
        }

        return $menu;
    }
}
