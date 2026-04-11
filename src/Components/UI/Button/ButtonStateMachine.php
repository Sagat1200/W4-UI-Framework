<?php

namespace W4\UiFramework\Components\UI\Button;

use RuntimeException;
use W4\UiFramework\Components\UI\Button\ButtonComponentEvent;
use W4\UiFramework\Components\UI\Button\ButtonComponentState;

class ButtonStateMachine
{
    public function canTransition(
        ButtonComponentState $from,
        ButtonComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        ButtonComponentState $from,
        ButtonComponentEvent $event
    ): ButtonComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        ButtonComponentState $from,
        ButtonComponentEvent $event
    ): ?ButtonComponentState {
        return match ($from) {
            ButtonComponentState::ENABLED => match ($event) {
                ButtonComponentEvent::CLICK => ButtonComponentState::ACTIVE,
                ButtonComponentEvent::DISABLE => ButtonComponentState::DISABLED,
                ButtonComponentEvent::START_LOADING => ButtonComponentState::LOADING,
                ButtonComponentEvent::SET_READONLY => ButtonComponentState::READONLY,
                ButtonComponentEvent::SET_ACTIVE => ButtonComponentState::ACTIVE,
                ButtonComponentEvent::RESET => ButtonComponentState::ENABLED,
                default => null,
            },

            ButtonComponentState::DISABLED => match ($event) {
                ButtonComponentEvent::ENABLE => ButtonComponentState::ENABLED,
                ButtonComponentEvent::RESET => ButtonComponentState::ENABLED,
                default => null,
            },

            ButtonComponentState::LOADING => match ($event) {
                ButtonComponentEvent::FINISH_LOADING => ButtonComponentState::ENABLED,
                ButtonComponentEvent::DISABLE => ButtonComponentState::DISABLED,
                ButtonComponentEvent::RESET => ButtonComponentState::ENABLED,
                default => null,
            },

            ButtonComponentState::READONLY => match ($event) {
                ButtonComponentEvent::ENABLE => ButtonComponentState::ENABLED,
                ButtonComponentEvent::DISABLE => ButtonComponentState::DISABLED,
                ButtonComponentEvent::RESET => ButtonComponentState::ENABLED,
                default => null,
            },

            ButtonComponentState::ACTIVE => match ($event) {
                ButtonComponentEvent::CLICK => ButtonComponentState::ENABLED,
                ButtonComponentEvent::ENABLE => ButtonComponentState::ENABLED,
                ButtonComponentEvent::DISABLE => ButtonComponentState::DISABLED,
                ButtonComponentEvent::START_LOADING => ButtonComponentState::LOADING,
                ButtonComponentEvent::RESET => ButtonComponentState::ENABLED,
                default => null,
            },
        };
    }
}
