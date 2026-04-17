<?php

namespace W4\UI\Framework\View\Components\Navigation\BreadCrumb;

use W4\UI\Framework\Components\Navigation\BreadCrumb\BreadCrumb as BreadCrumbComponent;
use W4\UI\Framework\Components\Navigation\BreadCrumb\BreadCrumbComponentEvent;
use W4\UI\Framework\Components\Navigation\BreadCrumb\BreadCrumbInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class BreadCrumb extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?array $items = null,
        public ?string $separator = '/',
        public ?string $homeLabel = 'Inicio',
        public ?string $homeUrl = '/',
        public bool $collapsed = false,
        public int $maxVisibleItems = 5,
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
        $breadCrumb = BreadCrumbComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->collapsed($this->collapsed)
            ->maxVisibleItems($this->maxVisibleItems);

        if ($this->items !== null) {
            $breadCrumb->items($this->items);
        }

        if ($this->separator !== null) {
            $breadCrumb->separator($this->separator);
        }

        if ($this->homeLabel !== null) {
            $breadCrumb->homeLabel($this->homeLabel);
        }

        if ($this->homeUrl !== null) {
            $breadCrumb->homeUrl($this->homeUrl);
        }

        if ($this->hidden) {
            $breadCrumb->dispatch(BreadCrumbComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $breadCrumb->dispatch(BreadCrumbComponentEvent::DISABLE);
        } elseif ($this->collapsed) {
            $breadCrumb->dispatch(BreadCrumbComponentEvent::COLLAPSE);
        } elseif ($this->active) {
            $breadCrumb->dispatch(BreadCrumbComponentEvent::ACTIVATE);
        }

        $breadCrumb->interactState(new BreadCrumbInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            collapsed: $this->collapsed,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $breadCrumb->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $breadCrumb->accessibilityState($accessibilityState);
        }

        return $breadCrumb;
    }
}
