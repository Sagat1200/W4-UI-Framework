<?php

namespace W4\UI\Framework\View\Components\Layout\Section;

use W4\UI\Framework\Components\Layout\Section\Section as SectionComponent;
use W4\UI\Framework\Components\Layout\Section\SectionComponentEvent;
use W4\UI\Framework\Components\Layout\Section\SectionInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Section extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $title = null,
        public ?string $subtitle = null,
        public ?string $content = null,
        public bool $collapsible = false,
        public bool $expanded = true,
        public bool $bordered = false,
        public bool $padded = true,
        public ?string $spacing = 'md',
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

        $section = SectionComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size)
            ->collapsible($this->collapsible)
            ->bordered($this->bordered)
            ->padded($this->padded);

        if ($this->title !== null) {
            $section->title($this->title);
        }

        if ($this->subtitle !== null) {
            $section->subtitle($this->subtitle);
        }

        if ($this->content !== null) {
            $section->content($this->content);
        }

        if ($this->spacing !== null) {
            $section->spacing($this->spacing);
        }

        if ($this->hidden) {
            $section->dispatch(SectionComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $section->dispatch(SectionComponentEvent::DISABLE);
        } elseif ($this->collapsible && ! $this->expanded) {
            $section->dispatch(SectionComponentEvent::COLLAPSE);
        } elseif ($this->active) {
            $section->dispatch(SectionComponentEvent::ACTIVATE);
        }

        $section->interactState(new SectionInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            expanded: $this->expanded,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $section->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $section->accessibilityState($accessibilityState);
        }

        return $section;
    }
}
