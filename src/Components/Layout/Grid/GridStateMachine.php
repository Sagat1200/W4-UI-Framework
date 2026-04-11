<?php

namespace W4\UiFramework\Components\Layout\Grid;

use RuntimeException;
use W4\UiFramework\Components\Layout\Grid\GridComponentEvent;
use W4\UiFramework\Components\Layout\Grid\GridComponentState;

class GridStateMachine
{
    public function canTransition(
        GridComponentState $from,
        GridComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        GridComponentState $from,
        GridComponentEvent $event
    ): GridComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        GridComponentState $from,
        GridComponentEvent $event
    ): ?GridComponentState {
        return match ($from) {
            GridComponentState::ENABLED => match ($event) {
                GridComponentEvent::ACTIVATE => GridComponentState::ACTIVE,
                GridComponentEvent::DISABLE => GridComponentState::DISABLED,
                GridComponentEvent::HIDE => GridComponentState::HIDDEN,
                GridComponentEvent::SET_DENSE,
                GridComponentEvent::SET_RELAXED,
                GridComponentEvent::RESET => GridComponentState::ENABLED,
                default => null,
            },
            GridComponentState::ACTIVE => match ($event) {
                GridComponentEvent::DEACTIVATE => GridComponentState::ENABLED,
                GridComponentEvent::DISABLE => GridComponentState::DISABLED,
                GridComponentEvent::HIDE => GridComponentState::HIDDEN,
                GridComponentEvent::SET_DENSE,
                GridComponentEvent::SET_RELAXED,
                GridComponentEvent::RESET => GridComponentState::ENABLED,
                default => null,
            },
            GridComponentState::DISABLED => match ($event) {
                GridComponentEvent::ENABLE => GridComponentState::ENABLED,
                GridComponentEvent::SHOW => GridComponentState::ENABLED,
                GridComponentEvent::RESET => GridComponentState::ENABLED,
                default => null,
            },
            GridComponentState::HIDDEN => match ($event) {
                GridComponentEvent::SHOW => GridComponentState::ENABLED,
                GridComponentEvent::DISABLE => GridComponentState::DISABLED,
                GridComponentEvent::RESET => GridComponentState::ENABLED,
                default => null,
            },
        };
    }
}
