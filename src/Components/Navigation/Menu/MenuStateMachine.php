<?php

namespace W4\UiFramework\Components\Navigation\Menu;

use RuntimeException;
use W4\UiFramework\Components\Navigation\Menu\MenuComponentEvent;
use W4\UiFramework\Components\Navigation\Menu\MenuComponentState;

class MenuStateMachine
{
    public function canTransition(
        MenuComponentState $from,
        MenuComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        MenuComponentState $from,
        MenuComponentEvent $event
    ): MenuComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        MenuComponentState $from,
        MenuComponentEvent $event
    ): ?MenuComponentState {
        return match ($from) {
            MenuComponentState::ENABLED => match ($event) {
                MenuComponentEvent::ACTIVATE => MenuComponentState::ACTIVE,
                MenuComponentEvent::DISABLE => MenuComponentState::DISABLED,
                MenuComponentEvent::HIDE => MenuComponentState::HIDDEN,
                MenuComponentEvent::OPEN => MenuComponentState::OPEN,
                MenuComponentEvent::TOGGLE => MenuComponentState::OPEN,
                MenuComponentEvent::RESET => MenuComponentState::ENABLED,
                default => null,
            },
            MenuComponentState::ACTIVE => match ($event) {
                MenuComponentEvent::DEACTIVATE => MenuComponentState::ENABLED,
                MenuComponentEvent::DISABLE => MenuComponentState::DISABLED,
                MenuComponentEvent::HIDE => MenuComponentState::HIDDEN,
                MenuComponentEvent::OPEN => MenuComponentState::OPEN,
                MenuComponentEvent::TOGGLE => MenuComponentState::OPEN,
                MenuComponentEvent::RESET => MenuComponentState::ENABLED,
                default => null,
            },
            MenuComponentState::OPEN => match ($event) {
                MenuComponentEvent::CLOSE => MenuComponentState::ENABLED,
                MenuComponentEvent::TOGGLE => MenuComponentState::ENABLED,
                MenuComponentEvent::HIDE => MenuComponentState::HIDDEN,
                MenuComponentEvent::DISABLE => MenuComponentState::DISABLED,
                MenuComponentEvent::RESET => MenuComponentState::ENABLED,
                default => null,
            },
            MenuComponentState::DISABLED => match ($event) {
                MenuComponentEvent::ENABLE => MenuComponentState::ENABLED,
                MenuComponentEvent::SHOW => MenuComponentState::ENABLED,
                MenuComponentEvent::RESET => MenuComponentState::ENABLED,
                default => null,
            },
            MenuComponentState::HIDDEN => match ($event) {
                MenuComponentEvent::SHOW => MenuComponentState::ENABLED,
                MenuComponentEvent::DISABLE => MenuComponentState::DISABLED,
                MenuComponentEvent::RESET => MenuComponentState::ENABLED,
                default => null,
            },
        };
    }
}
