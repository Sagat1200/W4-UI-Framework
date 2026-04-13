<?php

namespace W4\UI\Framework\View\Components\FeedBack;

use W4\UI\Framework\Components\FeedBack\Toast\Toast as ToastComponent;
use W4\UI\Framework\Components\FeedBack\Toast\ToastComponentEvent;
use W4\UI\Framework\Components\FeedBack\Toast\ToastInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Toast extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $title = null,
        public ?string $message = null,
        public ?string $icon = null,
        public ?string $tone = 'info',
        public string $variant = 'info',
        public string $size = 'md',
        public bool $dismissible = true,
        public bool $dismissed = false,
        public bool $autoDismiss = true,
        public int $duration = 3000,
        public string $vertical = 'bottom',
        public string $horizontal = 'end',
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
        $baseLabel = $this->label ?? $this->title ?? $this->message;

        $toast = ToastComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size)
            ->dismissible($this->dismissible)
            ->autoDismiss($this->autoDismiss)
            ->duration($this->duration)
            ->vertical($this->vertical)
            ->horizontal($this->horizontal);

        if ($this->title !== null) {
            $toast->title($this->title);
        }

        if ($this->message !== null) {
            $toast->message($this->message);
        }

        if ($this->icon !== null) {
            $toast->icon($this->icon);
        }

        if ($this->tone !== null) {
            $toast->tone($this->tone);
        }

        if ($this->hidden) {
            $toast->dispatch(ToastComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $toast->dispatch(ToastComponentEvent::DISABLE);
        } elseif ($this->dismissed) {
            $toast->dispatch(ToastComponentEvent::DISMISS);
        } elseif ($this->active) {
            $toast->dispatch(ToastComponentEvent::ACTIVATE);
        }

        $toast->interactState(new ToastInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            dismissed: $this->dismissed,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $toast->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $toast->accessibilityState($accessibilityState);
        }

        return $toast;
    }
}
