<?php

namespace W4\UI\Framework\View\Components\Forms;

use W4\UI\Framework\Components\Forms\TextArea\TextArea as TextAreaComponent;
use W4\UI\Framework\Components\Forms\TextArea\TextAreaComponentEvent;
use W4\UI\Framework\Components\Forms\TextArea\TextAreaInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class TextArea extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $value = null,
        public ?string $placeholder = null,
        public int $rows = 3,
        public ?int $cols = null,
        public string $resize = 'vertical',
        public ?string $helperText = null,
        public ?string $errorMessage = null,
        public string $variant = 'default',
        public string $size = 'md',
        public bool $disabled = false,
        public bool $loading = false,
        public bool $readonly = false,
        public bool $invalid = false,
        public bool $valid = false,
        public bool $focused = false,
        public bool $hovered = false,
        public bool $filled = false,
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
        $textArea = TextAreaComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->rows($this->rows)
            ->resize($this->resize);

        if ($this->value !== null) {
            $textArea->value($this->value);
        }

        if ($this->placeholder !== null) {
            $textArea->placeholder($this->placeholder);
        }

        if ($this->cols !== null) {
            $textArea->cols($this->cols);
        }

        if ($this->helperText !== null) {
            $textArea->helperText($this->helperText);
        }

        if ($this->errorMessage !== null) {
            $textArea->errorMessage($this->errorMessage);
        }

        if ($this->loading) {
            $textArea->dispatch(TextAreaComponentEvent::START_LOADING);
        } elseif ($this->disabled) {
            $textArea->dispatch(TextAreaComponentEvent::DISABLE);
        } elseif ($this->readonly) {
            $textArea->dispatch(TextAreaComponentEvent::SET_READONLY);
        } elseif ($this->invalid || $this->errorMessage) {
            $textArea->dispatch(TextAreaComponentEvent::SET_INVALID);
        } elseif ($this->valid) {
            $textArea->dispatch(TextAreaComponentEvent::SET_VALID);
        }

        $textArea->interactState(new TextAreaInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            filled: $this->filled || (($this->value ?? '') !== ''),
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $textArea->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $textArea->accessibilityState($accessibilityState);
        }

        return $textArea;
    }
}
