<?php

namespace W4\UiFramework\View\Components\UI;

use W4\UiFramework\Components\UI\Heading\Heading as HeadingComponent;
use W4\UiFramework\Components\UI\Heading\HeadingComponentEvent;
use W4\UiFramework\Components\UI\Heading\HeadingInteractState;
use W4\UiFramework\Contracts\ComponentInterface;
use W4\UiFramework\View\Components\BaseW4BladeComponent;

class Heading extends BaseW4BladeComponent
{
    public function __construct(
        public ?string $label = null,
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $text = null,
        public string $level = 'h2',
        public string $variant = 'neutral',
        public ?string $size = null,
        public bool $disabled = false,
        public bool $active = false,
        public bool $hidden = false,
        public bool $focused = false,
        public bool $hovered = false,
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
        $heading = HeadingComponent::make($this->label)
            ->variant($this->variant)
            ->level($this->level);

        if ($this->size !== null && $this->size !== '') {
            $heading->size($this->size);
        }

        if ($this->text !== null) {
            $heading->text($this->text);
        }

        if ($this->hidden) {
            $heading->dispatch(HeadingComponentEvent::HIDE);
        } elseif ($this->disabled) {
            $heading->dispatch(HeadingComponentEvent::DISABLE);
        } elseif ($this->active) {
            $heading->dispatch(HeadingComponentEvent::ACTIVATE);
        }

        $heading->interactState(new HeadingInteractState(
            hovered: $this->hovered,
            focused: $this->focused,
        ));

        return $heading;
    }
}
