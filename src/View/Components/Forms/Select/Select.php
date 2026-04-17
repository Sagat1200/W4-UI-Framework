<?php

namespace W4\UI\Framework\View\Components\Forms\Select;

use W4\UI\Framework\Components\Forms\Select\Select as SelectComponent;
use W4\UI\Framework\Components\Forms\Select\SelectComponentEvent;
use W4\UI\Framework\Components\Forms\Select\SelectInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Select extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public array $options = [],
        public string|array|null $selected = null,
        public ?string $placeholder = null,
        public bool $multiple = false,
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
        public bool $opened = false,
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
        $select = SelectComponent::make($this->label)
            ->variant($this->variant)
            ->size($this->size)
            ->multiple($this->multiple)
            ->options($this->options)
            ->selected($this->selected);

        if ($this->placeholder !== null) {
            $select->placeholder($this->placeholder);
        }

        if ($this->helperText !== null) {
            $select->helperText($this->helperText);
        }

        if ($this->errorMessage !== null) {
            $select->errorMessage($this->errorMessage);
        }

        if ($this->loading) {
            $select->dispatch(SelectComponentEvent::START_LOADING);
        } elseif ($this->disabled) {
            $select->dispatch(SelectComponentEvent::DISABLE);
        } elseif ($this->readonly) {
            $select->dispatch(SelectComponentEvent::SET_READONLY);
        } elseif ($this->invalid || $this->errorMessage) {
            $select->dispatch(SelectComponentEvent::SET_INVALID);
        } elseif ($this->valid) {
            $select->dispatch(SelectComponentEvent::SET_VALID);
        }

        $select->interactState(new SelectInteractState(
            focused: $this->focused,
            hovered: $this->hovered,
            opened: $this->opened,
        ));

        if ($this->ariaLabel !== null || $this->ariaDescribedBy !== null) {
            $accessibilityState = $select->accessibilityState();

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            if ($this->ariaDescribedBy !== null) {
                $accessibilityState->ariaDescribedBy = $this->ariaDescribedBy;
            }

            $select->accessibilityState($accessibilityState);
        }

        return $select;
    }
}
