<?php

namespace W4\UI\Framework\View\Components\Layout;

use W4\UI\Framework\Components\Layout\Grid\Grid as GridComponent;
use W4\UI\Framework\Components\Layout\Grid\GridComponentEvent;
use W4\UI\Framework\Components\Layout\Grid\GridInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Grid extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?array $items = null,
        public int $columns = 12,
        public ?string $gap = 'md',
        public ?string $rowGap = null,
        public ?string $columnGap = null,
        public bool $dense = false,
        public ?string $alignItems = null,
        public ?string $justifyItems = null,
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
        $grid = GridComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->columns($this->columns)
            ->dense($this->dense);

        if ($this->items !== null) {
            $grid->items($this->items);
        }

        if ($this->gap !== null) {
            $grid->gap($this->gap);
        }

        if ($this->rowGap !== null) {
            $grid->rowGap($this->rowGap);
        }

        if ($this->columnGap !== null) {
            $grid->columnGap($this->columnGap);
        }

        if ($this->alignItems !== null) {
            $grid->alignItems($this->alignItems);
        }

        if ($this->justifyItems !== null) {
            $grid->justifyItems($this->justifyItems);
        }

        if ($this->hidden) {
            $grid->dispatch(GridComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $grid->dispatch(GridComponentEvent::DISABLE);
        } elseif ($this->dense) {
            $grid->dispatch(GridComponentEvent::SET_DENSE);
        } elseif ($this->active) {
            $grid->dispatch(GridComponentEvent::ACTIVATE);
        }

        $grid->interactState(new GridInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            dense: $this->dense,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $grid->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $grid->accessibilityState($accessibilityState);
        }

        return $grid;
    }
}
