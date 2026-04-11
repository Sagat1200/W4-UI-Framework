<?php

namespace W4\UiFramework\Components\Navigation\DropDown;

use RuntimeException;
use W4\UiFramework\Components\Navigation\DropDown\DropDownComponentEvent;
use W4\UiFramework\Components\Navigation\DropDown\DropDownComponentState;

class DropDownStateMachine
{
    public function canTransition(
        DropDownComponentState $from,
        DropDownComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        DropDownComponentState $from,
        DropDownComponentEvent $event
    ): DropDownComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        DropDownComponentState $from,
        DropDownComponentEvent $event
    ): ?DropDownComponentState {
        return match ($from) {
            DropDownComponentState::ENABLED => match ($event) {
                DropDownComponentEvent::ACTIVATE => DropDownComponentState::ACTIVE,
                DropDownComponentEvent::DISABLE => DropDownComponentState::DISABLED,
                DropDownComponentEvent::HIDE => DropDownComponentState::HIDDEN,
                DropDownComponentEvent::OPEN => DropDownComponentState::OPEN,
                DropDownComponentEvent::TOGGLE => DropDownComponentState::OPEN,
                DropDownComponentEvent::RESET => DropDownComponentState::ENABLED,
                default => null,
            },
            DropDownComponentState::ACTIVE => match ($event) {
                DropDownComponentEvent::DEACTIVATE => DropDownComponentState::ENABLED,
                DropDownComponentEvent::DISABLE => DropDownComponentState::DISABLED,
                DropDownComponentEvent::HIDE => DropDownComponentState::HIDDEN,
                DropDownComponentEvent::OPEN => DropDownComponentState::OPEN,
                DropDownComponentEvent::TOGGLE => DropDownComponentState::OPEN,
                DropDownComponentEvent::RESET => DropDownComponentState::ENABLED,
                default => null,
            },
            DropDownComponentState::OPEN => match ($event) {
                DropDownComponentEvent::CLOSE => DropDownComponentState::ENABLED,
                DropDownComponentEvent::TOGGLE => DropDownComponentState::ENABLED,
                DropDownComponentEvent::HIDE => DropDownComponentState::HIDDEN,
                DropDownComponentEvent::DISABLE => DropDownComponentState::DISABLED,
                DropDownComponentEvent::RESET => DropDownComponentState::ENABLED,
                default => null,
            },
            DropDownComponentState::DISABLED => match ($event) {
                DropDownComponentEvent::ENABLE => DropDownComponentState::ENABLED,
                DropDownComponentEvent::SHOW => DropDownComponentState::ENABLED,
                DropDownComponentEvent::RESET => DropDownComponentState::ENABLED,
                default => null,
            },
            DropDownComponentState::HIDDEN => match ($event) {
                DropDownComponentEvent::SHOW => DropDownComponentState::ENABLED,
                DropDownComponentEvent::DISABLE => DropDownComponentState::DISABLED,
                DropDownComponentEvent::RESET => DropDownComponentState::ENABLED,
                default => null,
            },
        };
    }
}
