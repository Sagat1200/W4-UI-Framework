<?php

namespace W4\UI\Framework\View\Components\Navigation\Drawer;

use W4\UI\Framework\Components\Navigation\Drawer\Drawer as DrawerComponent;
use W4\UI\Framework\Components\Navigation\Drawer\DrawerComponentEvent;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class Drawer extends BaseW4BladeComponent
{
    public function __construct(
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public bool $open = false,
        public string $position = 'right',
        public bool $overlay = true,
        public ?string $ariaLabelledBy = null,
        public ?string $ariaLabel = null,
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
        $drawer = DrawerComponent::make()
            ->position($this->position)
            ->overlay($this->overlay);

        if ($this->open) {
            $drawer->dispatch(DrawerComponentEvent::OPEN);
        } else {
            $drawer->dispatch(DrawerComponentEvent::CLOSE);
        }

        if ($this->ariaLabelledBy !== null || $this->ariaLabel !== null) {
            $accessibilityState = $drawer->accessibilityState();

            if ($this->ariaLabelledBy !== null) {
                $accessibilityState->ariaLabelledBy = $this->ariaLabelledBy;
            }

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            $drawer->accessibilityState($accessibilityState);
        }

        return $drawer;
    }
}
