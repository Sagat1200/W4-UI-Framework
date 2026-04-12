<?php

namespace W4\UI\Framework\Components\Forms\Input;

use RuntimeException;
use W4\UI\Framework\Components\Forms\Input\InputComponentEvent;
use W4\UI\Framework\Components\Forms\Input\InputComponentState;

class InputStateMachine
{
    public function canTransition(
        InputComponentState $from,
        InputComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        InputComponentState $from,
        InputComponentEvent $event
    ): InputComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        InputComponentState $from,
        InputComponentEvent $event
    ): ?InputComponentState {
        return match ($from) {
            InputComponentState::ENABLED => match ($event) {
                InputComponentEvent::DISABLE => InputComponentState::DISABLED,
                InputComponentEvent::SET_READONLY => InputComponentState::READONLY,
                InputComponentEvent::SET_INVALID => InputComponentState::INVALID,
                InputComponentEvent::SET_VALID => InputComponentState::VALID,
                InputComponentEvent::START_LOADING => InputComponentState::LOADING,
                InputComponentEvent::RESET => InputComponentState::ENABLED,
                default => null,
            },

            InputComponentState::DISABLED => match ($event) {
                InputComponentEvent::ENABLE => InputComponentState::ENABLED,
                InputComponentEvent::RESET => InputComponentState::ENABLED,
                default => null,
            },

            InputComponentState::READONLY => match ($event) {
                InputComponentEvent::ENABLE => InputComponentState::ENABLED,
                InputComponentEvent::DISABLE => InputComponentState::DISABLED,
                InputComponentEvent::SET_INVALID => InputComponentState::INVALID,
                InputComponentEvent::SET_VALID => InputComponentState::VALID,
                InputComponentEvent::RESET => InputComponentState::ENABLED,
                default => null,
            },

            InputComponentState::INVALID => match ($event) {
                InputComponentEvent::SET_VALID => InputComponentState::VALID,
                InputComponentEvent::ENABLE => InputComponentState::ENABLED,
                InputComponentEvent::DISABLE => InputComponentState::DISABLED,
                InputComponentEvent::SET_READONLY => InputComponentState::READONLY,
                InputComponentEvent::RESET => InputComponentState::ENABLED,
                default => null,
            },

            InputComponentState::VALID => match ($event) {
                InputComponentEvent::SET_INVALID => InputComponentState::INVALID,
                InputComponentEvent::ENABLE => InputComponentState::ENABLED,
                InputComponentEvent::DISABLE => InputComponentState::DISABLED,
                InputComponentEvent::SET_READONLY => InputComponentState::READONLY,
                InputComponentEvent::RESET => InputComponentState::ENABLED,
                default => null,
            },

            InputComponentState::LOADING => match ($event) {
                InputComponentEvent::FINISH_LOADING => InputComponentState::ENABLED,
                InputComponentEvent::DISABLE => InputComponentState::DISABLED,
                InputComponentEvent::SET_READONLY => InputComponentState::READONLY,
                InputComponentEvent::SET_INVALID => InputComponentState::INVALID,
                InputComponentEvent::SET_VALID => InputComponentState::VALID,
                InputComponentEvent::RESET => InputComponentState::ENABLED,
                default => null,
            },
        };
    }
}