<?php

namespace W4\UI\Framework\View\Components\FeedBack\Skeleton;

use W4\UI\Framework\Components\FeedBack\Skeleton\Skeleton as SkeletonComponent;
use W4\UI\Framework\Components\FeedBack\Skeleton\SkeletonComponentEvent;
use W4\UI\Framework\Components\FeedBack\Skeleton\SkeletonInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Skeleton extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $shape = 'line',
        public ?string $width = null,
        public ?string $height = null,
        public bool $animated = true,
        public ?int $lines = 1,
        public string $variant = 'line',
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
        $skeleton = SkeletonComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->animated($this->animated);

        if ($this->shape !== null) {
            $skeleton->shape($this->shape);
        }

        if ($this->width !== null) {
            $skeleton->width($this->width);
        }

        if ($this->height !== null) {
            $skeleton->height($this->height);
        }

        if ($this->lines !== null) {
            $skeleton->lines($this->lines);
        }

        if ($this->hidden) {
            $skeleton->dispatch(SkeletonComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $skeleton->dispatch(SkeletonComponentEvent::DISABLE);
        } elseif ($this->loading) {
            $skeleton->dispatch(SkeletonComponentEvent::START_LOADING);
        } elseif ($this->active) {
            $skeleton->dispatch(SkeletonComponentEvent::ACTIVATE);
        }

        $skeleton->interactState(new SkeletonInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            loading: $this->loading,
            animated: $this->animated,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $skeleton->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $skeleton->accessibilityState($accessibilityState);
        }

        return $skeleton;
    }
}
