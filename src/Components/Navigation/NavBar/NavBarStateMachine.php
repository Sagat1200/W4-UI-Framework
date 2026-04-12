<?php

namespace W4\UI\Framework\Components\Navigation\NavBar;

use RuntimeException;
use W4\UI\Framework\Components\Navigation\NavBar\NavBarComponentEvent;
use W4\UI\Framework\Components\Navigation\NavBar\NavBarComponentState;

class NavBarStateMachine
{
    public function canTransition(
        NavBarComponentState $from,
        NavBarComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        NavBarComponentState $from,
        NavBarComponentEvent $event
    ): NavBarComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        NavBarComponentState $from,
        NavBarComponentEvent $event
    ): ?NavBarComponentState {
        return match ($from) {
            NavBarComponentState::ENABLED => match ($event) {
                NavBarComponentEvent::ACTIVATE => NavBarComponentState::ACTIVE,
                NavBarComponentEvent::DISABLE => NavBarComponentState::DISABLED,
                NavBarComponentEvent::HIDE => NavBarComponentState::HIDDEN,
                NavBarComponentEvent::COLLAPSE => NavBarComponentState::COLLAPSED,
                NavBarComponentEvent::TOGGLE_MOBILE,
                NavBarComponentEvent::RESET => NavBarComponentState::ENABLED,
                default => null,
            },
            NavBarComponentState::ACTIVE => match ($event) {
                NavBarComponentEvent::DEACTIVATE => NavBarComponentState::ENABLED,
                NavBarComponentEvent::DISABLE => NavBarComponentState::DISABLED,
                NavBarComponentEvent::HIDE => NavBarComponentState::HIDDEN,
                NavBarComponentEvent::COLLAPSE => NavBarComponentState::COLLAPSED,
                NavBarComponentEvent::TOGGLE_MOBILE,
                NavBarComponentEvent::RESET => NavBarComponentState::ENABLED,
                default => null,
            },
            NavBarComponentState::DISABLED => match ($event) {
                NavBarComponentEvent::ENABLE => NavBarComponentState::ENABLED,
                NavBarComponentEvent::SHOW => NavBarComponentState::ENABLED,
                NavBarComponentEvent::RESET => NavBarComponentState::ENABLED,
                default => null,
            },
            NavBarComponentState::HIDDEN => match ($event) {
                NavBarComponentEvent::SHOW => NavBarComponentState::ENABLED,
                NavBarComponentEvent::DISABLE => NavBarComponentState::DISABLED,
                NavBarComponentEvent::RESET => NavBarComponentState::ENABLED,
                default => null,
            },
            NavBarComponentState::COLLAPSED => match ($event) {
                NavBarComponentEvent::EXPAND => NavBarComponentState::ENABLED,
                NavBarComponentEvent::HIDE => NavBarComponentState::HIDDEN,
                NavBarComponentEvent::DISABLE => NavBarComponentState::DISABLED,
                NavBarComponentEvent::TOGGLE_MOBILE => NavBarComponentState::COLLAPSED,
                NavBarComponentEvent::RESET => NavBarComponentState::ENABLED,
                default => null,
            },
        };
    }
}