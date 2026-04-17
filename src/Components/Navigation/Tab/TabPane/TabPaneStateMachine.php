<?php

namespace W4\UI\Framework\Components\Navigation\Tab\TabPane;

use RuntimeException;
use W4\UI\Framework\Components\Navigation\Tab\TabPane\TabPaneComponentEvent;
use W4\UI\Framework\Components\Navigation\Tab\TabPane\TabPaneComponentState;

class TabPaneStateMachine
{
    public function canTransition(
        TabPaneComponentState $from,
        TabPaneComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        TabPaneComponentState $from,
        TabPaneComponentEvent $event
    ): TabPaneComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        TabPaneComponentState $from,
        TabPaneComponentEvent $event
    ): ?TabPaneComponentState {
        return match ($from) {
            TabPaneComponentState::ENABLED => match ($event) {
                TabPaneComponentEvent::ACTIVATE => TabPaneComponentState::ACTIVE,
                TabPaneComponentEvent::HIDE => TabPaneComponentState::HIDDEN,
                TabPaneComponentEvent::RESET => TabPaneComponentState::ENABLED,
                default => null,
            },
            TabPaneComponentState::ACTIVE => match ($event) {
                TabPaneComponentEvent::DEACTIVATE => TabPaneComponentState::ENABLED,
                TabPaneComponentEvent::HIDE => TabPaneComponentState::HIDDEN,
                TabPaneComponentEvent::RESET => TabPaneComponentState::ENABLED,
                default => null,
            },
            TabPaneComponentState::HIDDEN => match ($event) {
                TabPaneComponentEvent::SHOW => TabPaneComponentState::ENABLED,
                TabPaneComponentEvent::ACTIVATE => TabPaneComponentState::ACTIVE,
                TabPaneComponentEvent::RESET => TabPaneComponentState::ENABLED,
                default => null,
            },
        };
    }
}
