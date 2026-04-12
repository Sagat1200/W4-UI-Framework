<?php

namespace W4\UiFramework\View\Components\Forms;

use W4\UiFramework\Components\Forms\FielError\FieldError as FieldErrorComponent;
use W4\UiFramework\Components\Forms\FielError\FieldErrorComponentEvent;
use W4\UiFramework\Components\Forms\FielError\FieldErrorInteractState;
use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\View\Components\BaseW4BladeComponent;

class FieldError extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $message = null,
        public ?string $forField = null,
        public ?string $code = null,
        public ?string $hint = null,
        public string $variant = 'error',
        public string $size = 'sm',
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
        $baseLabel = $this->label ?? $this->message;

        $fieldError = FieldErrorComponent::make($baseLabel)
            ->variant($this->variant)
            ->size($this->size);

        if ($this->message !== null) {
            $fieldError->message($this->message);
        } elseif ($this->label !== null) {
            $fieldError->message($this->label);
        }

        if ($this->forField !== null) {
            $fieldError->forField($this->forField);
        }

        if ($this->code !== null) {
            $fieldError->code($this->code);
        }

        if ($this->hint !== null) {
            $fieldError->hint($this->hint);
        }

        if ($this->hidden) {
            $fieldError->dispatch(FieldErrorComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $fieldError->dispatch(FieldErrorComponentEvent::DISABLE);
        } elseif ($this->active) {
            $fieldError->dispatch(FieldErrorComponentEvent::ACTIVATE);
        }

        $fieldError->interactState(new FieldErrorInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $fieldError->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $fieldError->accessibilityState($accessibilityState);
        }

        return $fieldError;
    }
}