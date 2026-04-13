<?php

namespace W4\UI\Framework\View\Components\FeedBack;

use W4\UI\Framework\Components\FeedBack\Loading\Loading as LoadingComponent;
use W4\UI\Framework\Components\FeedBack\Loading\LoadingComponentEvent;
use W4\UI\Framework\Components\FeedBack\Loading\LoadingInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Loading extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $type = 'spinner',
        public ?string $message = null,
        public bool $overlay = false,
        public bool $loading = false,
        public ?string $speed = 'normal',
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
        $loading = LoadingComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->overlay($this->overlay)
            ->loading($this->loading);

        if ($this->type !== null) {
            $loading->type($this->type);
        }

        if ($this->message !== null) {
            $loading->message($this->message);
        }

        if ($this->speed !== null) {
            $loading->speed($this->speed);
        }

        if ($this->hidden) {
            $loading->dispatch(LoadingComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $loading->dispatch(LoadingComponentEvent::DISABLE);
        } elseif ($this->loading) {
            $loading->dispatch(LoadingComponentEvent::START);
        } elseif ($this->active) {
            $loading->dispatch(LoadingComponentEvent::ACTIVATE);
        }

        $loading->interactState(new LoadingInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            loading: $this->loading,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $loading->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $loading->accessibilityState($accessibilityState);
        }

        return $loading;
    }
}
