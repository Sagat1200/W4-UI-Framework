<?php

namespace W4\UI\Framework\View\Components\Layout;

use W4\UI\Framework\Components\Layout\Stack\Stack as StackComponent;
use W4\UI\Framework\Components\Layout\Stack\StackComponentEvent;
use W4\UI\Framework\Components\Layout\Stack\StackInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Stack extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?array $items = null,
        public ?string $direction = 'vertical',
        public ?string $gap = 'md',
        public bool $wrap = false,
        public ?string $alignItems = null,
        public ?string $justifyContent = null,
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
        $stack = StackComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->wrap($this->wrap);

        if ($this->items !== null) {
            $stack->items($this->items);
        }

        if ($this->direction !== null) {
            $stack->direction($this->direction);
        }

        if ($this->gap !== null) {
            $stack->gap($this->gap);
        }

        if ($this->alignItems !== null) {
            $stack->alignItems($this->alignItems);
        }

        if ($this->justifyContent !== null) {
            $stack->justifyContent($this->justifyContent);
        }

        if ($this->hidden) {
            $stack->dispatch(StackComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $stack->dispatch(StackComponentEvent::DISABLE);
        } elseif ($this->direction === 'horizontal') {
            $stack->dispatch(StackComponentEvent::SET_HORIZONTAL);
        } elseif ($this->wrap) {
            $stack->dispatch(StackComponentEvent::SET_WRAP);
        } elseif ($this->active) {
            $stack->dispatch(StackComponentEvent::ACTIVATE);
        }

        $stack->interactState(new StackInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            wrapped: $this->wrap,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $stack->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $stack->accessibilityState($accessibilityState);
        }

        return $stack;
    }
}
