<?php

namespace W4\UI\Framework\Components\Layout\Stack;

use RuntimeException;
use W4\UI\Framework\Components\Layout\Stack\StackComponentEvent;
use W4\UI\Framework\Components\Layout\Stack\StackComponentState;

class StackStateMachine
{
    public function canTransition(
        StackComponentState $from,
        StackComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        StackComponentState $from,
        StackComponentEvent $event
    ): StackComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        StackComponentState $from,
        StackComponentEvent $event
    ): ?StackComponentState {
        return match ($from) {
            StackComponentState::ENABLED => match ($event) {
                StackComponentEvent::ACTIVATE => StackComponentState::ACTIVE,
                StackComponentEvent::DISABLE => StackComponentState::DISABLED,
                StackComponentEvent::HIDE => StackComponentState::HIDDEN,
                StackComponentEvent::SET_HORIZONTAL,
                StackComponentEvent::SET_VERTICAL,
                StackComponentEvent::SET_WRAP,
                StackComponentEvent::SET_NOWRAP,
                StackComponentEvent::RESET => StackComponentState::ENABLED,
                default => null,
            },
            StackComponentState::ACTIVE => match ($event) {
                StackComponentEvent::DEACTIVATE => StackComponentState::ENABLED,
                StackComponentEvent::DISABLE => StackComponentState::DISABLED,
                StackComponentEvent::HIDE => StackComponentState::HIDDEN,
                StackComponentEvent::SET_HORIZONTAL,
                StackComponentEvent::SET_VERTICAL,
                StackComponentEvent::SET_WRAP,
                StackComponentEvent::SET_NOWRAP,
                StackComponentEvent::RESET => StackComponentState::ENABLED,
                default => null,
            },
            StackComponentState::DISABLED => match ($event) {
                StackComponentEvent::ENABLE => StackComponentState::ENABLED,
                StackComponentEvent::SHOW => StackComponentState::ENABLED,
                StackComponentEvent::RESET => StackComponentState::ENABLED,
                default => null,
            },
            StackComponentState::HIDDEN => match ($event) {
                StackComponentEvent::SHOW => StackComponentState::ENABLED,
                StackComponentEvent::DISABLE => StackComponentState::DISABLED,
                StackComponentEvent::RESET => StackComponentState::ENABLED,
                default => null,
            },
        };
    }
}