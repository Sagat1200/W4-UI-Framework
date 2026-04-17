<?php

namespace W4\UI\Framework\View\Components\Navigation\DropDown;

use W4\UI\Framework\Components\Navigation\DropDown\DropDown as DropDownComponent;
use W4\UI\Framework\Components\Navigation\DropDown\DropDownComponentEvent;
use W4\UI\Framework\Components\Navigation\DropDown\DropDownInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class DropDown extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?array $items = null,
        public ?string $placement = 'bottom-start',
        public bool $opened = false,
        public bool $searchable = false,
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
        $dropDown = DropDownComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->opened($this->opened)
            ->searchable($this->searchable);

        if ($this->items !== null) {
            $dropDown->items($this->items);
        }

        if ($this->placement !== null) {
            $dropDown->placement($this->placement);
        }

        if ($this->trigger !== null) {
            $dropDown->trigger($this->trigger);
        }

        if ($this->hidden) {
            $dropDown->dispatch(DropDownComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $dropDown->dispatch(DropDownComponentEvent::DISABLE);
        } elseif ($this->opened) {
            $dropDown->dispatch(DropDownComponentEvent::OPEN);
        } elseif ($this->active) {
            $dropDown->dispatch(DropDownComponentEvent::ACTIVATE);
        }

        $dropDown->interactState(new DropDownInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            opened: $this->opened,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $dropDown->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $dropDown->accessibilityState($accessibilityState);
        }

        return $dropDown;
    }
}
