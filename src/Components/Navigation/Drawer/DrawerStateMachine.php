<?php

namespace W4\UI\Framework\Components\Navigation\Drawer;

use RuntimeException;
use W4\UI\Framework\Components\Navigation\Drawer\DrawerComponentEvent;
use W4\UI\Framework\Components\Navigation\Drawer\DrawerComponentState;

class DrawerStateMachine
{
    public function canTransition(
        DrawerComponentState $from,
        DrawerComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        DrawerComponentState $from,
        DrawerComponentEvent $event
    ): DrawerComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transición inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        DrawerComponentState $from,
        DrawerComponentEvent $event
    ): ?DrawerComponentState {
        return match ($from) {
            DrawerComponentState::CLOSED => match ($event) {
                DrawerComponentEvent::OPEN, DrawerComponentEvent::TOGGLE => DrawerComponentState::OPEN,
                default => null,
            },
            DrawerComponentState::OPEN => match ($event) {
                DrawerComponentEvent::CLOSE, DrawerComponentEvent::TOGGLE => DrawerComponentState::CLOSED,
                default => null,
            },
        };
    }
}
