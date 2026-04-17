<?php

namespace W4\UI\Framework\View\Components\Navigation\Tab\TabPane;

use W4\UI\Framework\Components\Navigation\Tab\TabPane\TabPane as TabPaneComponent;
use W4\UI\Framework\Components\Navigation\Tab\TabPane\TabPaneComponentEvent;
use W4\UI\Framework\Components\Navigation\Tab\TabPane\TabPaneInteractState;
use W4\UI\Framework\Contracts\ComponentInterface;
use W4\UI\Framework\View\Components\BaseW4BladeComponent;

class TabPane extends BaseW4BladeComponent
{
    public function __construct(
        ?string $id = null,
        ?string $name = null,
        ?string $theme = null,
        ?string $renderer = null,
        string|int|null $componentId = null,
        public ?string $value = null,
        public bool $active = false,
        public bool $hidden = false,
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
        $tabPane = TabPaneComponent::make()
            ->active($this->active);

        if ($this->value !== null) {
            $tabPane->value($this->value);
        }

        if ($this->hidden) {
            $tabPane->dispatch(TabPaneComponentEvent::HIDE);
        } elseif ($this->active) {
            $tabPane->dispatch(TabPaneComponentEvent::ACTIVATE);
        }

        $tabPane->interactState(new TabPaneInteractState(
            active: $this->active,
        ));

        if ($this->ariaLabelledBy !== null || $this->ariaLabel !== null) {
            $accessibilityState = $tabPane->accessibilityState();

            if ($this->ariaLabelledBy !== null) {
                $accessibilityState->ariaLabelledBy = $this->ariaLabelledBy;
            }

            if ($this->ariaLabel !== null) {
                $accessibilityState->ariaLabel = $this->ariaLabel;
            }

            $tabPane->accessibilityState($accessibilityState);
        }

        return $tabPane;
    }
}
