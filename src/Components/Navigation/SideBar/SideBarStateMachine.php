<?php

namespace W4\UiFramework\Components\Navigation\SideBar;

use RuntimeException;
use W4\UiFramework\Components\Navigation\SideBar\SideBarComponentEvent;
use W4\UiFramework\Components\Navigation\SideBar\SideBarComponentState;

class SideBarStateMachine
{
    public function canTransition(
        SideBarComponentState $from,
        SideBarComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        SideBarComponentState $from,
        SideBarComponentEvent $event
    ): SideBarComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        SideBarComponentState $from,
        SideBarComponentEvent $event
    ): ?SideBarComponentState {
        return match ($from) {
            SideBarComponentState::ENABLED => match ($event) {
                SideBarComponentEvent::ACTIVATE => SideBarComponentState::ACTIVE,
                SideBarComponentEvent::DISABLE => SideBarComponentState::DISABLED,
                SideBarComponentEvent::HIDE => SideBarComponentState::HIDDEN,
                SideBarComponentEvent::COLLAPSE => SideBarComponentState::COLLAPSED,
                SideBarComponentEvent::TOGGLE => SideBarComponentState::COLLAPSED,
                SideBarComponentEvent::RESET => SideBarComponentState::ENABLED,
                default => null,
            },
            SideBarComponentState::ACTIVE => match ($event) {
                SideBarComponentEvent::DEACTIVATE => SideBarComponentState::ENABLED,
                SideBarComponentEvent::DISABLE => SideBarComponentState::DISABLED,
                SideBarComponentEvent::HIDE => SideBarComponentState::HIDDEN,
                SideBarComponentEvent::COLLAPSE => SideBarComponentState::COLLAPSED,
                SideBarComponentEvent::TOGGLE => SideBarComponentState::COLLAPSED,
                SideBarComponentEvent::RESET => SideBarComponentState::ENABLED,
                default => null,
            },
            SideBarComponentState::COLLAPSED => match ($event) {
                SideBarComponentEvent::EXPAND => SideBarComponentState::ENABLED,
                SideBarComponentEvent::TOGGLE => SideBarComponentState::ENABLED,
                SideBarComponentEvent::HIDE => SideBarComponentState::HIDDEN,
                SideBarComponentEvent::DISABLE => SideBarComponentState::DISABLED,
                SideBarComponentEvent::RESET => SideBarComponentState::ENABLED,
                default => null,
            },
            SideBarComponentState::DISABLED => match ($event) {
                SideBarComponentEvent::ENABLE => SideBarComponentState::ENABLED,
                SideBarComponentEvent::SHOW => SideBarComponentState::ENABLED,
                SideBarComponentEvent::RESET => SideBarComponentState::ENABLED,
                default => null,
            },
            SideBarComponentState::HIDDEN => match ($event) {
                SideBarComponentEvent::SHOW => SideBarComponentState::ENABLED,
                SideBarComponentEvent::DISABLE => SideBarComponentState::DISABLED,
                SideBarComponentEvent::RESET => SideBarComponentState::ENABLED,
                default => null,
            },
        };
    }
}
