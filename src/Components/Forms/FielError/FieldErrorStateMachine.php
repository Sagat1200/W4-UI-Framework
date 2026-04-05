<?php

namespace W4\UiFramework\Components\Forms\FielError;

use RuntimeException;

class FieldErrorStateMachine
{
    public function canTransition(
        FieldErrorComponentState $from,
        FieldErrorComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        FieldErrorComponentState $from,
        FieldErrorComponentEvent $event
    ): FieldErrorComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        FieldErrorComponentState $from,
        FieldErrorComponentEvent $event
    ): ?FieldErrorComponentState {
        return match ($from) {
            FieldErrorComponentState::ENABLED => match ($event) {
                FieldErrorComponentEvent::ACTIVATE => FieldErrorComponentState::ACTIVE,
                FieldErrorComponentEvent::DISABLE => FieldErrorComponentState::DISABLED,
                FieldErrorComponentEvent::HIDE => FieldErrorComponentState::HIDDEN,
                FieldErrorComponentEvent::RESET => FieldErrorComponentState::ENABLED,
                default => null,
            },

            FieldErrorComponentState::ACTIVE => match ($event) {
                FieldErrorComponentEvent::DEACTIVATE => FieldErrorComponentState::ENABLED,
                FieldErrorComponentEvent::DISABLE => FieldErrorComponentState::DISABLED,
                FieldErrorComponentEvent::HIDE => FieldErrorComponentState::HIDDEN,
                FieldErrorComponentEvent::RESET => FieldErrorComponentState::ENABLED,
                default => null,
            },

            FieldErrorComponentState::DISABLED => match ($event) {
                FieldErrorComponentEvent::ENABLE => FieldErrorComponentState::ENABLED,
                FieldErrorComponentEvent::RESET => FieldErrorComponentState::ENABLED,
                default => null,
            },

            FieldErrorComponentState::HIDDEN => match ($event) {
                FieldErrorComponentEvent::SHOW => FieldErrorComponentState::ENABLED,
                FieldErrorComponentEvent::DISABLE => FieldErrorComponentState::DISABLED,
                FieldErrorComponentEvent::RESET => FieldErrorComponentState::ENABLED,
                default => null,
            },
        };
    }
}
