<?php

namespace W4\UiFramework\Components\Forms\Radio;

use RuntimeException;

class RadioStateMachine
{
    public function canTransition(
        RadioComponentState $from,
        RadioComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        RadioComponentState $from,
        RadioComponentEvent $event
    ): RadioComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        RadioComponentState $from,
        RadioComponentEvent $event
    ): ?RadioComponentState {
        return match ($from) {
            RadioComponentState::ENABLED => match ($event) {
                RadioComponentEvent::FOCUS,
                RadioComponentEvent::BLUR,
                RadioComponentEvent::CHANGE,
                RadioComponentEvent::SELECT,
                RadioComponentEvent::CLEAR => RadioComponentState::ENABLED,
                RadioComponentEvent::DISABLE => RadioComponentState::DISABLED,
                RadioComponentEvent::SET_READONLY => RadioComponentState::READONLY,
                RadioComponentEvent::SET_INVALID => RadioComponentState::INVALID,
                RadioComponentEvent::SET_VALID => RadioComponentState::VALID,
                RadioComponentEvent::START_LOADING => RadioComponentState::LOADING,
                RadioComponentEvent::RESET => RadioComponentState::ENABLED,
                default => null,
            },

            RadioComponentState::DISABLED => match ($event) {
                RadioComponentEvent::ENABLE => RadioComponentState::ENABLED,
                RadioComponentEvent::RESET => RadioComponentState::ENABLED,
                default => null,
            },

            RadioComponentState::READONLY => match ($event) {
                RadioComponentEvent::FOCUS,
                RadioComponentEvent::BLUR => RadioComponentState::READONLY,
                RadioComponentEvent::ENABLE => RadioComponentState::ENABLED,
                RadioComponentEvent::DISABLE => RadioComponentState::DISABLED,
                RadioComponentEvent::SET_INVALID => RadioComponentState::INVALID,
                RadioComponentEvent::SET_VALID => RadioComponentState::VALID,
                RadioComponentEvent::RESET => RadioComponentState::ENABLED,
                default => null,
            },

            RadioComponentState::INVALID => match ($event) {
                RadioComponentEvent::FOCUS,
                RadioComponentEvent::BLUR,
                RadioComponentEvent::CHANGE,
                RadioComponentEvent::SELECT,
                RadioComponentEvent::CLEAR => RadioComponentState::INVALID,
                RadioComponentEvent::SET_VALID => RadioComponentState::VALID,
                RadioComponentEvent::ENABLE => RadioComponentState::ENABLED,
                RadioComponentEvent::DISABLE => RadioComponentState::DISABLED,
                RadioComponentEvent::SET_READONLY => RadioComponentState::READONLY,
                RadioComponentEvent::RESET => RadioComponentState::ENABLED,
                default => null,
            },

            RadioComponentState::VALID => match ($event) {
                RadioComponentEvent::FOCUS,
                RadioComponentEvent::BLUR,
                RadioComponentEvent::CHANGE,
                RadioComponentEvent::SELECT,
                RadioComponentEvent::CLEAR => RadioComponentState::VALID,
                RadioComponentEvent::SET_INVALID => RadioComponentState::INVALID,
                RadioComponentEvent::ENABLE => RadioComponentState::ENABLED,
                RadioComponentEvent::DISABLE => RadioComponentState::DISABLED,
                RadioComponentEvent::SET_READONLY => RadioComponentState::READONLY,
                RadioComponentEvent::RESET => RadioComponentState::ENABLED,
                default => null,
            },

            RadioComponentState::LOADING => match ($event) {
                RadioComponentEvent::FINISH_LOADING => RadioComponentState::ENABLED,
                RadioComponentEvent::DISABLE => RadioComponentState::DISABLED,
                RadioComponentEvent::SET_READONLY => RadioComponentState::READONLY,
                RadioComponentEvent::SET_INVALID => RadioComponentState::INVALID,
                RadioComponentEvent::SET_VALID => RadioComponentState::VALID,
                RadioComponentEvent::RESET => RadioComponentState::ENABLED,
                default => null,
            },
        };
    }
}
