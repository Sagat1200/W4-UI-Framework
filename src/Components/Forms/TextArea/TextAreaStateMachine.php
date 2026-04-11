<?php

namespace W4\UiFramework\Components\Forms\TextArea;

use RuntimeException;
use W4\UiFramework\Components\Forms\TextArea\TextAreaComponentEvent;
use W4\UiFramework\Components\Forms\TextArea\TextAreaComponentState;

class TextAreaStateMachine
{
    public function canTransition(
        TextAreaComponentState $from,
        TextAreaComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        TextAreaComponentState $from,
        TextAreaComponentEvent $event
    ): TextAreaComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        TextAreaComponentState $from,
        TextAreaComponentEvent $event
    ): ?TextAreaComponentState {
        return match ($from) {
            TextAreaComponentState::ENABLED => match ($event) {
                TextAreaComponentEvent::DISABLE => TextAreaComponentState::DISABLED,
                TextAreaComponentEvent::SET_READONLY => TextAreaComponentState::READONLY,
                TextAreaComponentEvent::SET_INVALID => TextAreaComponentState::INVALID,
                TextAreaComponentEvent::SET_VALID => TextAreaComponentState::VALID,
                TextAreaComponentEvent::START_LOADING => TextAreaComponentState::LOADING,
                TextAreaComponentEvent::RESET => TextAreaComponentState::ENABLED,
                default => null,
            },

            TextAreaComponentState::DISABLED => match ($event) {
                TextAreaComponentEvent::ENABLE => TextAreaComponentState::ENABLED,
                TextAreaComponentEvent::RESET => TextAreaComponentState::ENABLED,
                default => null,
            },

            TextAreaComponentState::READONLY => match ($event) {
                TextAreaComponentEvent::ENABLE => TextAreaComponentState::ENABLED,
                TextAreaComponentEvent::DISABLE => TextAreaComponentState::DISABLED,
                TextAreaComponentEvent::SET_INVALID => TextAreaComponentState::INVALID,
                TextAreaComponentEvent::SET_VALID => TextAreaComponentState::VALID,
                TextAreaComponentEvent::RESET => TextAreaComponentState::ENABLED,
                default => null,
            },

            TextAreaComponentState::INVALID => match ($event) {
                TextAreaComponentEvent::SET_VALID => TextAreaComponentState::VALID,
                TextAreaComponentEvent::ENABLE => TextAreaComponentState::ENABLED,
                TextAreaComponentEvent::DISABLE => TextAreaComponentState::DISABLED,
                TextAreaComponentEvent::SET_READONLY => TextAreaComponentState::READONLY,
                TextAreaComponentEvent::RESET => TextAreaComponentState::ENABLED,
                default => null,
            },

            TextAreaComponentState::VALID => match ($event) {
                TextAreaComponentEvent::SET_INVALID => TextAreaComponentState::INVALID,
                TextAreaComponentEvent::ENABLE => TextAreaComponentState::ENABLED,
                TextAreaComponentEvent::DISABLE => TextAreaComponentState::DISABLED,
                TextAreaComponentEvent::SET_READONLY => TextAreaComponentState::READONLY,
                TextAreaComponentEvent::RESET => TextAreaComponentState::ENABLED,
                default => null,
            },

            TextAreaComponentState::LOADING => match ($event) {
                TextAreaComponentEvent::FINISH_LOADING => TextAreaComponentState::ENABLED,
                TextAreaComponentEvent::DISABLE => TextAreaComponentState::DISABLED,
                TextAreaComponentEvent::SET_READONLY => TextAreaComponentState::READONLY,
                TextAreaComponentEvent::SET_INVALID => TextAreaComponentState::INVALID,
                TextAreaComponentEvent::SET_VALID => TextAreaComponentState::VALID,
                TextAreaComponentEvent::RESET => TextAreaComponentState::ENABLED,
                default => null,
            },
        };
    }
}
