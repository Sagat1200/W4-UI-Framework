<?php

namespace W4\UI\Framework\View\Components\Interactive;

use W4\UI\Framework\Components\Interactive\Tooltip\Tooltip as TooltipComponent;
use W4\UI\Framework\Components\Interactive\Tooltip\TooltipComponentEvent;
use W4\UI\Framework\Components\Interactive\Tooltip\TooltipInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Tooltip extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $text = null,
        public ?string $placement = 'top',
        public ?string $trigger = 'hover',
        public bool $opened = false,
        public ?int $delay = 0,
        public bool $arrow = true,
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
        $baseLabel = $this->label ?? $this->text;

        $tooltip = TooltipComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size)
            ->opened($this->opened)
            ->arrow($this->arrow);

        if ($this->text !== null) {
            $tooltip->text($this->text);
        }

        if ($this->placement !== null) {
            $tooltip->placement($this->placement);
        }

        if ($this->trigger !== null) {
            $tooltip->trigger($this->trigger);
        }

        if ($this->delay !== null) {
            $tooltip->delay($this->delay);
        }

        if ($this->hidden) {
            $tooltip->dispatch(TooltipComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $tooltip->dispatch(TooltipComponentEvent::DISABLE);
        } elseif ($this->opened) {
            $tooltip->dispatch(TooltipComponentEvent::OPEN);
        } elseif ($this->active) {
            $tooltip->dispatch(TooltipComponentEvent::ACTIVATE);
        }

        $tooltip->interactState(new TooltipInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            opened: $this->opened,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $tooltip->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $tooltip->accessibilityState($accessibilityState);
        }

        return $tooltip;
    }
}
