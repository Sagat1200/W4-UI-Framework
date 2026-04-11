<?php

namespace W4\UiFramework\Components\UI\Icon;

use RuntimeException;
use W4\UiFramework\Components\UI\Icon\IconComponentEvent;
use W4\UiFramework\Components\UI\Icon\IconComponentState;

class IconStateMachine
{
    public function canTransition(
        IconComponentState $from,
        IconComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        IconComponentState $from,
        IconComponentEvent $event
    ): IconComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        IconComponentState $from,
        IconComponentEvent $event
    ): ?IconComponentState {
        return match ($from) {
            IconComponentState::ENABLED => match ($event) {
                IconComponentEvent::ACTIVATE => IconComponentState::ACTIVE,
                IconComponentEvent::DISABLE => IconComponentState::DISABLED,
                IconComponentEvent::HIDE => IconComponentState::HIDDEN,
                IconComponentEvent::RESET => IconComponentState::ENABLED,
                default => null,
            },
            IconComponentState::ACTIVE => match ($event) {
                IconComponentEvent::DEACTIVATE => IconComponentState::ENABLED,
                IconComponentEvent::DISABLE => IconComponentState::DISABLED,
                IconComponentEvent::HIDE => IconComponentState::HIDDEN,
                IconComponentEvent::RESET => IconComponentState::ENABLED,
                default => null,
            },
            IconComponentState::DISABLED => match ($event) {
                IconComponentEvent::ENABLE => IconComponentState::ENABLED,
                IconComponentEvent::SHOW => IconComponentState::ENABLED,
                IconComponentEvent::RESET => IconComponentState::ENABLED,
                default => null,
            },
            IconComponentState::HIDDEN => match ($event) {
                IconComponentEvent::SHOW => IconComponentState::ENABLED,
                IconComponentEvent::DISABLE => IconComponentState::DISABLED,
                IconComponentEvent::RESET => IconComponentState::ENABLED,
                default => null,
            },
        };
    }
}
