<?php

namespace W4\UiFramework\Components\Forms\Toggle;

use RuntimeException;
use W4\UiFramework\Components\Forms\Toggle\ToggleComponentEvent;
use W4\UiFramework\Components\Forms\Toggle\ToggleComponentState;

class ToggleStateMachine
{
    public function canTransition(
        ToggleComponentState $from,
        ToggleComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        ToggleComponentState $from,
        ToggleComponentEvent $event
    ): ToggleComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        ToggleComponentState $from,
        ToggleComponentEvent $event
    ): ?ToggleComponentState {
        return match ($from) {
            ToggleComponentState::ENABLED => match ($event) {
                ToggleComponentEvent::FOCUS,
                ToggleComponentEvent::BLUR,
                ToggleComponentEvent::CHANGE,
                ToggleComponentEvent::CHECK,
                ToggleComponentEvent::UNCHECK,
                ToggleComponentEvent::TOGGLE => ToggleComponentState::ENABLED,
                ToggleComponentEvent::DISABLE => ToggleComponentState::DISABLED,
                ToggleComponentEvent::SET_READONLY => ToggleComponentState::READONLY,
                ToggleComponentEvent::SET_INVALID => ToggleComponentState::INVALID,
                ToggleComponentEvent::SET_VALID => ToggleComponentState::VALID,
                ToggleComponentEvent::START_LOADING => ToggleComponentState::LOADING,
                ToggleComponentEvent::RESET => ToggleComponentState::ENABLED,
                default => null,
            },

            ToggleComponentState::DISABLED => match ($event) {
                ToggleComponentEvent::ENABLE => ToggleComponentState::ENABLED,
                ToggleComponentEvent::RESET => ToggleComponentState::ENABLED,
                default => null,
            },

            ToggleComponentState::READONLY => match ($event) {
                ToggleComponentEvent::FOCUS,
                ToggleComponentEvent::BLUR => ToggleComponentState::READONLY,
                ToggleComponentEvent::ENABLE => ToggleComponentState::ENABLED,
                ToggleComponentEvent::DISABLE => ToggleComponentState::DISABLED,
                ToggleComponentEvent::SET_INVALID => ToggleComponentState::INVALID,
                ToggleComponentEvent::SET_VALID => ToggleComponentState::VALID,
                ToggleComponentEvent::RESET => ToggleComponentState::ENABLED,
                default => null,
            },

            ToggleComponentState::INVALID => match ($event) {
                ToggleComponentEvent::FOCUS,
                ToggleComponentEvent::BLUR,
                ToggleComponentEvent::CHANGE,
                ToggleComponentEvent::CHECK,
                ToggleComponentEvent::UNCHECK,
                ToggleComponentEvent::TOGGLE => ToggleComponentState::INVALID,
                ToggleComponentEvent::SET_VALID => ToggleComponentState::VALID,
                ToggleComponentEvent::ENABLE => ToggleComponentState::ENABLED,
                ToggleComponentEvent::DISABLE => ToggleComponentState::DISABLED,
                ToggleComponentEvent::SET_READONLY => ToggleComponentState::READONLY,
                ToggleComponentEvent::RESET => ToggleComponentState::ENABLED,
                default => null,
            },

            ToggleComponentState::VALID => match ($event) {
                ToggleComponentEvent::FOCUS,
                ToggleComponentEvent::BLUR,
                ToggleComponentEvent::CHANGE,
                ToggleComponentEvent::CHECK,
                ToggleComponentEvent::UNCHECK,
                ToggleComponentEvent::TOGGLE => ToggleComponentState::VALID,
                ToggleComponentEvent::SET_INVALID => ToggleComponentState::INVALID,
                ToggleComponentEvent::ENABLE => ToggleComponentState::ENABLED,
                ToggleComponentEvent::DISABLE => ToggleComponentState::DISABLED,
                ToggleComponentEvent::SET_READONLY => ToggleComponentState::READONLY,
                ToggleComponentEvent::RESET => ToggleComponentState::ENABLED,
                default => null,
            },

            ToggleComponentState::LOADING => match ($event) {
                ToggleComponentEvent::FINISH_LOADING => ToggleComponentState::ENABLED,
                ToggleComponentEvent::DISABLE => ToggleComponentState::DISABLED,
                ToggleComponentEvent::SET_READONLY => ToggleComponentState::READONLY,
                ToggleComponentEvent::SET_INVALID => ToggleComponentState::INVALID,
                ToggleComponentEvent::SET_VALID => ToggleComponentState::VALID,
                ToggleComponentEvent::RESET => ToggleComponentState::ENABLED,
                default => null,
            },
        };
    }
}
