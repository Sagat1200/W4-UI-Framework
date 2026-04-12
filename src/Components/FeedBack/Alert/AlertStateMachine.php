<?php

namespace W4\UI\Framework\Components\FeedBack\Alert;

use RuntimeException;
use W4\UI\Framework\Components\FeedBack\Alert\AlertComponentEvent;
use W4\UI\Framework\Components\FeedBack\Alert\AlertComponentState;

class AlertStateMachine
{
    public function canTransition(
        AlertComponentState $from,
        AlertComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        AlertComponentState $from,
        AlertComponentEvent $event
    ): AlertComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        AlertComponentState $from,
        AlertComponentEvent $event
    ): ?AlertComponentState {
        return match ($from) {
            AlertComponentState::ENABLED => match ($event) {
                AlertComponentEvent::ACTIVATE => AlertComponentState::ACTIVE,
                AlertComponentEvent::DISABLE => AlertComponentState::DISABLED,
                AlertComponentEvent::HIDE => AlertComponentState::HIDDEN,
                AlertComponentEvent::DISMISS => AlertComponentState::DISMISSED,
                AlertComponentEvent::RESET => AlertComponentState::ENABLED,
                default => null,
            },
            AlertComponentState::ACTIVE => match ($event) {
                AlertComponentEvent::DEACTIVATE => AlertComponentState::ENABLED,
                AlertComponentEvent::DISABLE => AlertComponentState::DISABLED,
                AlertComponentEvent::HIDE => AlertComponentState::HIDDEN,
                AlertComponentEvent::DISMISS => AlertComponentState::DISMISSED,
                AlertComponentEvent::RESET => AlertComponentState::ENABLED,
                default => null,
            },
            AlertComponentState::DISMISSED => match ($event) {
                AlertComponentEvent::SHOW => AlertComponentState::ENABLED,
                AlertComponentEvent::RESET => AlertComponentState::ENABLED,
                default => null,
            },
            AlertComponentState::DISABLED => match ($event) {
                AlertComponentEvent::ENABLE => AlertComponentState::ENABLED,
                AlertComponentEvent::SHOW => AlertComponentState::ENABLED,
                AlertComponentEvent::RESET => AlertComponentState::ENABLED,
                default => null,
            },
            AlertComponentState::HIDDEN => match ($event) {
                AlertComponentEvent::SHOW => AlertComponentState::ENABLED,
                AlertComponentEvent::DISABLE => AlertComponentState::DISABLED,
                AlertComponentEvent::RESET => AlertComponentState::ENABLED,
                default => null,
            },
        };
    }
}