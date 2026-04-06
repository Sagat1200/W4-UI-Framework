<?php

namespace W4\UiFramework\Components\Forms\Select;

use RuntimeException;

class SelectStateMachine
{
    public function canTransition(
        SelectComponentState $from,
        SelectComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        SelectComponentState $from,
        SelectComponentEvent $event
    ): SelectComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        SelectComponentState $from,
        SelectComponentEvent $event
    ): ?SelectComponentState {
        return match ($from) {
            SelectComponentState::ENABLED => match ($event) {
                SelectComponentEvent::FOCUS,
                SelectComponentEvent::BLUR,
                SelectComponentEvent::CHANGE,
                SelectComponentEvent::SELECT,
                SelectComponentEvent::CLEAR => SelectComponentState::ENABLED,
                SelectComponentEvent::DISABLE => SelectComponentState::DISABLED,
                SelectComponentEvent::SET_READONLY => SelectComponentState::READONLY,
                SelectComponentEvent::SET_INVALID => SelectComponentState::INVALID,
                SelectComponentEvent::SET_VALID => SelectComponentState::VALID,
                SelectComponentEvent::START_LOADING => SelectComponentState::LOADING,
                SelectComponentEvent::RESET => SelectComponentState::ENABLED,
                default => null,
            },

            SelectComponentState::DISABLED => match ($event) {
                SelectComponentEvent::ENABLE => SelectComponentState::ENABLED,
                SelectComponentEvent::RESET => SelectComponentState::ENABLED,
                default => null,
            },

            SelectComponentState::READONLY => match ($event) {
                SelectComponentEvent::FOCUS,
                SelectComponentEvent::BLUR => SelectComponentState::READONLY,
                SelectComponentEvent::ENABLE => SelectComponentState::ENABLED,
                SelectComponentEvent::DISABLE => SelectComponentState::DISABLED,
                SelectComponentEvent::SET_INVALID => SelectComponentState::INVALID,
                SelectComponentEvent::SET_VALID => SelectComponentState::VALID,
                SelectComponentEvent::RESET => SelectComponentState::ENABLED,
                default => null,
            },

            SelectComponentState::INVALID => match ($event) {
                SelectComponentEvent::FOCUS,
                SelectComponentEvent::BLUR,
                SelectComponentEvent::CHANGE,
                SelectComponentEvent::SELECT,
                SelectComponentEvent::CLEAR => SelectComponentState::INVALID,
                SelectComponentEvent::SET_VALID => SelectComponentState::VALID,
                SelectComponentEvent::ENABLE => SelectComponentState::ENABLED,
                SelectComponentEvent::DISABLE => SelectComponentState::DISABLED,
                SelectComponentEvent::SET_READONLY => SelectComponentState::READONLY,
                SelectComponentEvent::RESET => SelectComponentState::ENABLED,
                default => null,
            },

            SelectComponentState::VALID => match ($event) {
                SelectComponentEvent::FOCUS,
                SelectComponentEvent::BLUR,
                SelectComponentEvent::CHANGE,
                SelectComponentEvent::SELECT,
                SelectComponentEvent::CLEAR => SelectComponentState::VALID,
                SelectComponentEvent::SET_INVALID => SelectComponentState::INVALID,
                SelectComponentEvent::ENABLE => SelectComponentState::ENABLED,
                SelectComponentEvent::DISABLE => SelectComponentState::DISABLED,
                SelectComponentEvent::SET_READONLY => SelectComponentState::READONLY,
                SelectComponentEvent::RESET => SelectComponentState::ENABLED,
                default => null,
            },

            SelectComponentState::LOADING => match ($event) {
                SelectComponentEvent::FINISH_LOADING => SelectComponentState::ENABLED,
                SelectComponentEvent::DISABLE => SelectComponentState::DISABLED,
                SelectComponentEvent::SET_READONLY => SelectComponentState::READONLY,
                SelectComponentEvent::SET_INVALID => SelectComponentState::INVALID,
                SelectComponentEvent::SET_VALID => SelectComponentState::VALID,
                SelectComponentEvent::RESET => SelectComponentState::ENABLED,
                default => null,
            },
        };
    }
}