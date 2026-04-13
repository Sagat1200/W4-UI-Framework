<?php

namespace W4\UI\Framework\View\Components\Interactive;

use W4\UI\Framework\Components\Interactive\Modal\Modal as ModalComponent;
use W4\UI\Framework\Components\Interactive\Modal\ModalComponentEvent;
use W4\UI\Framework\Components\Interactive\Modal\ModalInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Modal extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $title = null,
        public ?string $content = null,
        public ?string $footer = null,
        public bool $opened = false,
        public bool $dismissible = true,
        public ?string $sizePreset = 'md',
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

        $modal = ModalComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size)
            ->opened($this->opened)
            ->dismissible($this->dismissible);

        if ($this->title !== null) {
            $modal->title($this->title);
        }

        if ($this->content !== null) {
            $modal->content($this->content);
        }

        if ($this->footer !== null) {
            $modal->footer($this->footer);
        }

        if ($this->sizePreset !== null) {
            $modal->sizePreset($this->sizePreset);
        }

        if ($this->hidden) {
            $modal->dispatch(ModalComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $modal->dispatch(ModalComponentEvent::DISABLE);
        } elseif ($this->opened) {
            $modal->dispatch(ModalComponentEvent::OPEN);
        } elseif ($this->active) {
            $modal->dispatch(ModalComponentEvent::ACTIVATE);
        }

        $modal->interactState(new ModalInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            opened: $this->opened,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $modal->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $modal->accessibilityState($accessibilityState);
        }

        return $modal;
    }
}
