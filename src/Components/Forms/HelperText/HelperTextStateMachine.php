<?php

namespace W4\UI\Framework\Components\Forms\HelperText;

use RuntimeException;
use W4\UI\Framework\Components\Forms\HelperText\HelperTextComponentEvent;
use W4\UI\Framework\Components\Forms\HelperText\HelperTextComponentState;

class HelperTextStateMachine
{
    public function canTransition(
        HelperTextComponentState $from,
        HelperTextComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        HelperTextComponentState $from,
        HelperTextComponentEvent $event
    ): HelperTextComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        HelperTextComponentState $from,
        HelperTextComponentEvent $event
    ): ?HelperTextComponentState {
        return match ($from) {
            HelperTextComponentState::ENABLED => match ($event) {
                HelperTextComponentEvent::ACTIVATE => HelperTextComponentState::ACTIVE,
                HelperTextComponentEvent::DISABLE => HelperTextComponentState::DISABLED,
                HelperTextComponentEvent::HIDE => HelperTextComponentState::HIDDEN,
                HelperTextComponentEvent::RESET => HelperTextComponentState::ENABLED,
                default => null,
            },

            HelperTextComponentState::ACTIVE => match ($event) {
                HelperTextComponentEvent::DEACTIVATE => HelperTextComponentState::ENABLED,
                HelperTextComponentEvent::DISABLE => HelperTextComponentState::DISABLED,
                HelperTextComponentEvent::HIDE => HelperTextComponentState::HIDDEN,
                HelperTextComponentEvent::RESET => HelperTextComponentState::ENABLED,
                default => null,
            },

            HelperTextComponentState::DISABLED => match ($event) {
                HelperTextComponentEvent::ENABLE => HelperTextComponentState::ENABLED,
                HelperTextComponentEvent::RESET => HelperTextComponentState::ENABLED,
                default => null,
            },

            HelperTextComponentState::HIDDEN => match ($event) {
                HelperTextComponentEvent::SHOW => HelperTextComponentState::ENABLED,
                HelperTextComponentEvent::DISABLE => HelperTextComponentState::DISABLED,
                HelperTextComponentEvent::RESET => HelperTextComponentState::ENABLED,
                default => null,
            },
        };
    }
}
