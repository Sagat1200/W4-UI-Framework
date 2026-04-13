<?php

namespace W4\UI\Framework\View\Components\FeedBack;

use W4\UI\Framework\Components\FeedBack\Alert\Alert as AlertComponent;
use W4\UI\Framework\Components\FeedBack\Alert\AlertComponentEvent;
use W4\UI\Framework\Components\FeedBack\Alert\AlertInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Alert extends BaseW4BladeComponent
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
        public string $variant = 'default',
        public string $size = 'md',
        public bool $dismissible = true,
        public bool $dismissed = false,
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

        $alert = AlertComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size)
            ->dismissible($this->dismissible);

        if ($this->title !== null) {
            $alert->title($this->title);
        }

        if ($this->message !== null) {
            $alert->message($this->message);
        }

        if ($this->icon !== null) {
            $alert->icon($this->icon);
        }

        if ($this->tone !== null) {
            $alert->tone($this->tone);
        }

        if ($this->hidden) {
            $alert->dispatch(AlertComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $alert->dispatch(AlertComponentEvent::DISABLE);
        } elseif ($this->dismissed) {
            $alert->dispatch(AlertComponentEvent::DISMISS);
        } elseif ($this->active) {
            $alert->dispatch(AlertComponentEvent::ACTIVATE);
        }

        $alert->interactState(new AlertInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            dismissed: $this->dismissed,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $alert->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $alert->accessibilityState($accessibilityState);
        }

        return $alert;
    }
}
