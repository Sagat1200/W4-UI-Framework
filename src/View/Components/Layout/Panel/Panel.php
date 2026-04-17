<?php

namespace W4\UI\Framework\View\Components\Layout\Panel;

use W4\UI\Framework\Components\Layout\Panel\Panel as PanelComponent;
use W4\UI\Framework\Components\Layout\Panel\PanelComponentEvent;
use W4\UI\Framework\Components\Layout\Panel\PanelInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Panel extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $title = null,
        public ?string $body = null,
        public ?string $footer = null,
        public bool $collapsible = false,
        public bool $expanded = true,
        public bool $bordered = true,
        public bool $padded = true,
        public ?string $tone = 'default',
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

        $panel = PanelComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size)
            ->collapsible($this->collapsible)
            ->bordered($this->bordered)
            ->padded($this->padded);

        if ($this->title !== null) {
            $panel->title($this->title);
        }

        if ($this->body !== null) {
            $panel->body($this->body);
        }

        if ($this->footer !== null) {
            $panel->footer($this->footer);
        }

        if ($this->tone !== null) {
            $panel->tone($this->tone);
        }

        if ($this->hidden) {
            $panel->dispatch(PanelComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $panel->dispatch(PanelComponentEvent::DISABLE);
        } elseif ($this->collapsible && ! $this->expanded) {
            $panel->dispatch(PanelComponentEvent::COLLAPSE);
        } elseif ($this->active) {
            $panel->dispatch(PanelComponentEvent::ACTIVATE);
        }

        $panel->interactState(new PanelInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            expanded: $this->expanded,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $panel->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $panel->accessibilityState($accessibilityState);
        }

        return $panel;
    }
}
