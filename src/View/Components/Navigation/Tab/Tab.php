<?php

namespace W4\UI\Framework\View\Components\Navigation\Tab;

use W4\UI\Framework\Components\Navigation\Tab\Tab as TabComponent;
use W4\UI\Framework\Components\Navigation\Tab\TabComponentEvent;
use W4\UI\Framework\Components\Navigation\Tab\TabInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Tab extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $value = null,
        public bool $selected = false,
        public bool $disabled = false,
        public ?string $icon = null,
        public ?string $href = null,
        public string $variant = 'default',
        public string $size = 'md',
        public bool $active = false,
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
        $tab = TabComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->selected($this->selected)
            ->disabled($this->disabled);

        if ($this->value !== null) {
            $tab->value($this->value);
        }

        if ($this->icon !== null) {
            $tab->icon($this->icon);
        }

        if ($this->href !== null) {
            $tab->href($this->href);
        }

        if ($this->hidden) {
            $tab->dispatch(TabComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $tab->dispatch(TabComponentEvent::DISABLE);
        } elseif ($this->selected) {
            $tab->dispatch(TabComponentEvent::SELECT);
        } elseif ($this->active) {
            $tab->dispatch(TabComponentEvent::ACTIVATE);
        }

        $tab->interactState(new TabInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            selected: $this->selected,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $tab->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $tab->accessibilityState($accessibilityState);
        }

        return $tab;
    }
}
