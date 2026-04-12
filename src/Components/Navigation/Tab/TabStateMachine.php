<?php

namespace W4\UI\Framework\Components\Navigation\Tab;

use RuntimeException;
use W4\UI\Framework\Components\Navigation\Tab\TabComponentEvent;
use W4\UI\Framework\Components\Navigation\Tab\TabComponentState;

class TabStateMachine
{
    public function canTransition(
        TabComponentState $from,
        TabComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        TabComponentState $from,
        TabComponentEvent $event
    ): TabComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        TabComponentState $from,
        TabComponentEvent $event
    ): ?TabComponentState {
        return match ($from) {
            TabComponentState::ENABLED => match ($event) {
                TabComponentEvent::ACTIVATE => TabComponentState::ACTIVE,
                TabComponentEvent::SELECT => TabComponentState::SELECTED,
                TabComponentEvent::DISABLE => TabComponentState::DISABLED,
                TabComponentEvent::HIDE => TabComponentState::HIDDEN,
                TabComponentEvent::RESET => TabComponentState::ENABLED,
                default => null,
            },
            TabComponentState::ACTIVE => match ($event) {
                TabComponentEvent::DEACTIVATE => TabComponentState::ENABLED,
                TabComponentEvent::SELECT => TabComponentState::SELECTED,
                TabComponentEvent::DISABLE => TabComponentState::DISABLED,
                TabComponentEvent::HIDE => TabComponentState::HIDDEN,
                TabComponentEvent::RESET => TabComponentState::ENABLED,
                default => null,
            },
            TabComponentState::SELECTED => match ($event) {
                TabComponentEvent::UNSELECT => TabComponentState::ENABLED,
                TabComponentEvent::HIDE => TabComponentState::HIDDEN,
                TabComponentEvent::DISABLE => TabComponentState::DISABLED,
                TabComponentEvent::RESET => TabComponentState::ENABLED,
                default => null,
            },
            TabComponentState::DISABLED => match ($event) {
                TabComponentEvent::ENABLE => TabComponentState::ENABLED,
                TabComponentEvent::SHOW => TabComponentState::ENABLED,
                TabComponentEvent::RESET => TabComponentState::ENABLED,
                default => null,
            },
            TabComponentState::HIDDEN => match ($event) {
                TabComponentEvent::SHOW => TabComponentState::ENABLED,
                TabComponentEvent::DISABLE => TabComponentState::DISABLED,
                TabComponentEvent::RESET => TabComponentState::ENABLED,
                default => null,
            },
        };
    }
}