<?php

namespace W4\UI\Framework\Components\Layout\Container;

use RuntimeException;
use W4\UI\Framework\Components\Layout\Container\ContainerComponentEvent;
use W4\UI\Framework\Components\Layout\Container\ContainerComponentState;

class ContainerStateMachine
{
    public function canTransition(
        ContainerComponentState $from,
        ContainerComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        ContainerComponentState $from,
        ContainerComponentEvent $event
    ): ContainerComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        ContainerComponentState $from,
        ContainerComponentEvent $event
    ): ?ContainerComponentState {
        return match ($from) {
            ContainerComponentState::ENABLED => match ($event) {
                ContainerComponentEvent::ACTIVATE => ContainerComponentState::ACTIVE,
                ContainerComponentEvent::DISABLE => ContainerComponentState::DISABLED,
                ContainerComponentEvent::HIDE => ContainerComponentState::HIDDEN,
                ContainerComponentEvent::SET_FLUID,
                ContainerComponentEvent::SET_FIXED,
                ContainerComponentEvent::RESET => ContainerComponentState::ENABLED,
                default => null,
            },
            ContainerComponentState::ACTIVE => match ($event) {
                ContainerComponentEvent::DEACTIVATE => ContainerComponentState::ENABLED,
                ContainerComponentEvent::DISABLE => ContainerComponentState::DISABLED,
                ContainerComponentEvent::HIDE => ContainerComponentState::HIDDEN,
                ContainerComponentEvent::SET_FLUID,
                ContainerComponentEvent::SET_FIXED,
                ContainerComponentEvent::RESET => ContainerComponentState::ENABLED,
                default => null,
            },
            ContainerComponentState::DISABLED => match ($event) {
                ContainerComponentEvent::ENABLE => ContainerComponentState::ENABLED,
                ContainerComponentEvent::SHOW => ContainerComponentState::ENABLED,
                ContainerComponentEvent::RESET => ContainerComponentState::ENABLED,
                default => null,
            },
            ContainerComponentState::HIDDEN => match ($event) {
                ContainerComponentEvent::SHOW => ContainerComponentState::ENABLED,
                ContainerComponentEvent::DISABLE => ContainerComponentState::DISABLED,
                ContainerComponentEvent::RESET => ContainerComponentState::ENABLED,
                default => null,
            },
        };
    }
}