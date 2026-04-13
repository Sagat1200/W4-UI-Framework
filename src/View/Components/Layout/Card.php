<?php

namespace W4\UI\Framework\View\Components\Layout;

use W4\UI\Framework\Components\Layout\Card\Card as CardComponent;
use W4\UI\Framework\Components\Layout\Card\CardComponentEvent;
use W4\UI\Framework\Components\Layout\Card\CardInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Card extends BaseW4BladeComponent
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
        public ?string $body = null,
        public ?string $footer = null,
        public bool $elevated = false,
        public bool $bordered = true,
        public bool $padded = true,
        public bool $collapsible = false,
        public bool $expanded = true,
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

        $card = CardComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size)
            ->elevated($this->elevated)
            ->bordered($this->bordered)
            ->padded($this->padded)
            ->collapsible($this->collapsible);

        if ($this->title !== null) {
            $card->title($this->title);
        }

        if ($this->subtitle !== null) {
            $card->subtitle($this->subtitle);
        }

        if ($this->body !== null) {
            $card->body($this->body);
        }

        if ($this->footer !== null) {
            $card->footer($this->footer);
        }

        if ($this->hidden) {
            $card->dispatch(CardComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $card->dispatch(CardComponentEvent::DISABLE);
        } elseif ($this->collapsible && ! $this->expanded) {
            $card->dispatch(CardComponentEvent::COLLAPSE);
        } elseif ($this->active) {
            $card->dispatch(CardComponentEvent::ACTIVATE);
        }

        $card->interactState(new CardInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            expanded: $this->expanded,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $card->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $card->accessibilityState($accessibilityState);
        }

        return $card;
    }
}
