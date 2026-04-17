<?php

namespace W4\UI\Framework\View\Components\Layout\Container;

use W4\UI\Framework\Components\Layout\Container\Container as ContainerComponent;
use W4\UI\Framework\Components\Layout\Container\ContainerComponentEvent;
use W4\UI\Framework\Components\Layout\Container\ContainerInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Container extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $content = null,
        public ?string $maxWidth = 'lg',
        public bool $fluid = false,
        public bool $centered = true,
        public bool $padded = true,
        public ?string $gap = 'md',
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
        $container = ContainerComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->fluid($this->fluid)
            ->centered($this->centered)
            ->padded($this->padded);

        if ($this->content !== null) {
            $container->content($this->content);
        }

        if ($this->maxWidth !== null) {
            $container->maxWidth($this->maxWidth);
        }

        if ($this->gap !== null) {
            $container->gap($this->gap);
        }

        if ($this->hidden) {
            $container->dispatch(ContainerComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $container->dispatch(ContainerComponentEvent::DISABLE);
        } elseif ($this->fluid) {
            $container->dispatch(ContainerComponentEvent::SET_FLUID);
        } elseif ($this->active) {
            $container->dispatch(ContainerComponentEvent::ACTIVATE);
        }

        $container->interactState(new ContainerInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            fluid: $this->fluid,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $container->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $container->accessibilityState($accessibilityState);
        }

        return $container;
    }
}
