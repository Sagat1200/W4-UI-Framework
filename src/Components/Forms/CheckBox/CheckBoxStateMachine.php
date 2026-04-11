<?php

namespace W4\UiFramework\Components\Forms\CheckBox;

use RuntimeException;
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentEvent;
use W4\UiFramework\Components\Forms\CheckBox\CheckBoxComponentState;

class CheckBoxStateMachine
{
    public function canTransition(
        CheckBoxComponentState $from,
        CheckBoxComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        CheckBoxComponentState $from,
        CheckBoxComponentEvent $event
    ): CheckBoxComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        CheckBoxComponentState $from,
        CheckBoxComponentEvent $event
    ): ?CheckBoxComponentState {
        return match ($from) {
            CheckBoxComponentState::ENABLED => match ($event) {
                CheckBoxComponentEvent::FOCUS,
                CheckBoxComponentEvent::BLUR,
                CheckBoxComponentEvent::CHANGE,
                CheckBoxComponentEvent::CHECK,
                CheckBoxComponentEvent::UNCHECK,
                CheckBoxComponentEvent::TOGGLE,
                CheckBoxComponentEvent::SET_INDETERMINATE,
                CheckBoxComponentEvent::CLEAR_INDETERMINATE => CheckBoxComponentState::ENABLED,
                CheckBoxComponentEvent::DISABLE => CheckBoxComponentState::DISABLED,
                CheckBoxComponentEvent::SET_READONLY => CheckBoxComponentState::READONLY,
                CheckBoxComponentEvent::SET_INVALID => CheckBoxComponentState::INVALID,
                CheckBoxComponentEvent::SET_VALID => CheckBoxComponentState::VALID,
                CheckBoxComponentEvent::START_LOADING => CheckBoxComponentState::LOADING,
                CheckBoxComponentEvent::RESET => CheckBoxComponentState::ENABLED,
                default => null,
            },

            CheckBoxComponentState::DISABLED => match ($event) {
                CheckBoxComponentEvent::ENABLE => CheckBoxComponentState::ENABLED,
                CheckBoxComponentEvent::RESET => CheckBoxComponentState::ENABLED,
                default => null,
            },

            CheckBoxComponentState::READONLY => match ($event) {
                CheckBoxComponentEvent::FOCUS,
                CheckBoxComponentEvent::BLUR => CheckBoxComponentState::READONLY,
                CheckBoxComponentEvent::ENABLE => CheckBoxComponentState::ENABLED,
                CheckBoxComponentEvent::DISABLE => CheckBoxComponentState::DISABLED,
                CheckBoxComponentEvent::SET_INVALID => CheckBoxComponentState::INVALID,
                CheckBoxComponentEvent::SET_VALID => CheckBoxComponentState::VALID,
                CheckBoxComponentEvent::RESET => CheckBoxComponentState::ENABLED,
                default => null,
            },

            CheckBoxComponentState::INVALID => match ($event) {
                CheckBoxComponentEvent::FOCUS,
                CheckBoxComponentEvent::BLUR,
                CheckBoxComponentEvent::CHANGE,
                CheckBoxComponentEvent::CHECK,
                CheckBoxComponentEvent::UNCHECK,
                CheckBoxComponentEvent::TOGGLE,
                CheckBoxComponentEvent::SET_INDETERMINATE,
                CheckBoxComponentEvent::CLEAR_INDETERMINATE => CheckBoxComponentState::INVALID,
                CheckBoxComponentEvent::SET_VALID => CheckBoxComponentState::VALID,
                CheckBoxComponentEvent::ENABLE => CheckBoxComponentState::ENABLED,
                CheckBoxComponentEvent::DISABLE => CheckBoxComponentState::DISABLED,
                CheckBoxComponentEvent::SET_READONLY => CheckBoxComponentState::READONLY,
                CheckBoxComponentEvent::RESET => CheckBoxComponentState::ENABLED,
                default => null,
            },

            CheckBoxComponentState::VALID => match ($event) {
                CheckBoxComponentEvent::FOCUS,
                CheckBoxComponentEvent::BLUR,
                CheckBoxComponentEvent::CHANGE,
                CheckBoxComponentEvent::CHECK,
                CheckBoxComponentEvent::UNCHECK,
                CheckBoxComponentEvent::TOGGLE,
                CheckBoxComponentEvent::SET_INDETERMINATE,
                CheckBoxComponentEvent::CLEAR_INDETERMINATE => CheckBoxComponentState::VALID,
                CheckBoxComponentEvent::SET_INVALID => CheckBoxComponentState::INVALID,
                CheckBoxComponentEvent::ENABLE => CheckBoxComponentState::ENABLED,
                CheckBoxComponentEvent::DISABLE => CheckBoxComponentState::DISABLED,
                CheckBoxComponentEvent::SET_READONLY => CheckBoxComponentState::READONLY,
                CheckBoxComponentEvent::RESET => CheckBoxComponentState::ENABLED,
                default => null,
            },

            CheckBoxComponentState::LOADING => match ($event) {
                CheckBoxComponentEvent::FINISH_LOADING => CheckBoxComponentState::ENABLED,
                CheckBoxComponentEvent::DISABLE => CheckBoxComponentState::DISABLED,
                CheckBoxComponentEvent::SET_READONLY => CheckBoxComponentState::READONLY,
                CheckBoxComponentEvent::SET_INVALID => CheckBoxComponentState::INVALID,
                CheckBoxComponentEvent::SET_VALID => CheckBoxComponentState::VALID,
                CheckBoxComponentEvent::RESET => CheckBoxComponentState::ENABLED,
                default => null,
            },
        };
    }
}
