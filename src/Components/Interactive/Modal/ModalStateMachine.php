<?php

namespace W4\UI\Framework\Components\Interactive\Modal;

use RuntimeException;
use W4\UI\Framework\Components\Interactive\Modal\ModalComponentEvent;
use W4\UI\Framework\Components\Interactive\Modal\ModalComponentState;

class ModalStateMachine
{
    public function canTransition(
        ModalComponentState $from,
        ModalComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        ModalComponentState $from,
        ModalComponentEvent $event
    ): ModalComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        ModalComponentState $from,
        ModalComponentEvent $event
    ): ?ModalComponentState {
        return match ($from) {
            ModalComponentState::ENABLED => match ($event) {
                ModalComponentEvent::ACTIVATE => ModalComponentState::ACTIVE,
                ModalComponentEvent::DISABLE => ModalComponentState::DISABLED,
                ModalComponentEvent::HIDE => ModalComponentState::HIDDEN,
                ModalComponentEvent::OPEN => ModalComponentState::OPEN,
                ModalComponentEvent::TOGGLE => ModalComponentState::OPEN,
                ModalComponentEvent::RESET => ModalComponentState::ENABLED,
                default => null,
            },
            ModalComponentState::ACTIVE => match ($event) {
                ModalComponentEvent::DEACTIVATE => ModalComponentState::ENABLED,
                ModalComponentEvent::DISABLE => ModalComponentState::DISABLED,
                ModalComponentEvent::HIDE => ModalComponentState::HIDDEN,
                ModalComponentEvent::OPEN => ModalComponentState::OPEN,
                ModalComponentEvent::TOGGLE => ModalComponentState::OPEN,
                ModalComponentEvent::RESET => ModalComponentState::ENABLED,
                default => null,
            },
            ModalComponentState::OPEN => match ($event) {
                ModalComponentEvent::CLOSE => ModalComponentState::ENABLED,
                ModalComponentEvent::TOGGLE => ModalComponentState::ENABLED,
                ModalComponentEvent::HIDE => ModalComponentState::HIDDEN,
                ModalComponentEvent::DISABLE => ModalComponentState::DISABLED,
                ModalComponentEvent::RESET => ModalComponentState::ENABLED,
                default => null,
            },
            ModalComponentState::DISABLED => match ($event) {
                ModalComponentEvent::ENABLE => ModalComponentState::ENABLED,
                ModalComponentEvent::SHOW => ModalComponentState::ENABLED,
                ModalComponentEvent::RESET => ModalComponentState::ENABLED,
                default => null,
            },
            ModalComponentState::HIDDEN => match ($event) {
                ModalComponentEvent::SHOW => ModalComponentState::ENABLED,
                ModalComponentEvent::DISABLE => ModalComponentState::DISABLED,
                ModalComponentEvent::RESET => ModalComponentState::ENABLED,
                default => null,
            },
        };
    }
}