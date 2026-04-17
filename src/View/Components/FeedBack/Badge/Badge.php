<?php

namespace W4\UI\Framework\View\Components\FeedBack\Badge;

use W4\UI\Framework\Components\FeedBack\Badge\Badge as BadgeComponent;
use W4\UI\Framework\Components\FeedBack\Badge\BadgeComponentEvent;
use W4\UI\Framework\Components\FeedBack\Badge\BadgeInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Badge extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $text = null,
        public ?string $icon = null,
        public ?string $tone = 'neutral',
        public string $variant = 'default',
        public string $size = 'md',
        public bool $pill = false,
        public bool $outlined = false,
        public bool $highlighted = false,
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

        $badge = BadgeComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size)
            ->pill($this->pill)
            ->outlined($this->outlined)
            ->highlighted($this->highlighted);

        if ($this->text !== null) {
            $badge->text($this->text);
        } elseif ($this->label !== null) {
            $badge->text($this->label);
        }

        if ($this->icon !== null) {
            $badge->icon($this->icon);
        }

        if ($this->tone !== null) {
            $badge->tone($this->tone);
        }

        if ($this->hidden) {
            $badge->dispatch(BadgeComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $badge->dispatch(BadgeComponentEvent::DISABLE);
        } elseif ($this->highlighted) {
            $badge->dispatch(BadgeComponentEvent::HIGHLIGHT);
        } elseif ($this->active) {
            $badge->dispatch(BadgeComponentEvent::ACTIVATE);
        }

        $badge->interactState(new BadgeInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            highlighted: $this->highlighted,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $badge->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $badge->accessibilityState($accessibilityState);
        }

        return $badge;
    }
}
