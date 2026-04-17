<?php

namespace W4\UI\Framework\View\Components\FeedBack\Progress;

use W4\UI\Framework\Components\FeedBack\Progress\Progress as ProgressComponent;
use W4\UI\Framework\Components\FeedBack\Progress\ProgressComponentEvent;
use W4\UI\Framework\Components\FeedBack\Progress\ProgressInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Progress extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?int $value = 0,
        public ?int $min = 0,
        public ?int $max = 100,
        public bool $indeterminate = false,
        public bool $striped = false,
        public bool $animated = false,
        public string $variant = 'default',
        public string $size = 'md',
        public bool $active = false,
        public bool $disabled = false,
        public bool $hidden = false,
        public bool $loading = false,
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
        $progress = ProgressComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->indeterminate($this->indeterminate)
            ->striped($this->striped)
            ->animated($this->animated);

        if ($this->value !== null) {
            $progress->value($this->value);
        }

        if ($this->min !== null) {
            $progress->min($this->min);
        }

        if ($this->max !== null) {
            $progress->max($this->max);
        }

        if ($this->hidden) {
            $progress->dispatch(ProgressComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $progress->dispatch(ProgressComponentEvent::DISABLE);
        } elseif ($this->indeterminate) {
            $progress->dispatch(ProgressComponentEvent::SET_INDETERMINATE);
        } elseif ($this->loading) {
            $progress->dispatch(ProgressComponentEvent::START_LOADING);
        } elseif ($this->active) {
            $progress->dispatch(ProgressComponentEvent::ACTIVATE);
        }

        $progress->interactState(new ProgressInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            loading: $this->loading,
            indeterminate: $this->indeterminate,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $progress->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $progress->accessibilityState($accessibilityState);
        }

        return $progress;
    }
}
