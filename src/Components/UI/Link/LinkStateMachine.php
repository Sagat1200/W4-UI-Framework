<?php

namespace W4\UI\Framework\Components\UI\Link;

use RuntimeException;
use W4\UI\Framework\Components\UI\Link\LinkComponentEvent;
use W4\UI\Framework\Components\UI\Link\LinkComponentState;

class LinkStateMachine
{
    public function canTransition(
        LinkComponentState $from,
        LinkComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        LinkComponentState $from,
        LinkComponentEvent $event
    ): LinkComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        LinkComponentState $from,
        LinkComponentEvent $event
    ): ?LinkComponentState {
        return match ($from) {
            LinkComponentState::ENABLED => match ($event) {
                LinkComponentEvent::ACTIVATE => LinkComponentState::ACTIVE,
                LinkComponentEvent::DISABLE => LinkComponentState::DISABLED,
                LinkComponentEvent::HIDE => LinkComponentState::HIDDEN,
                LinkComponentEvent::RESET => LinkComponentState::ENABLED,
                default => null,
            },
            LinkComponentState::ACTIVE => match ($event) {
                LinkComponentEvent::DEACTIVATE => LinkComponentState::ENABLED,
                LinkComponentEvent::DISABLE => LinkComponentState::DISABLED,
                LinkComponentEvent::HIDE => LinkComponentState::HIDDEN,
                LinkComponentEvent::RESET => LinkComponentState::ENABLED,
                default => null,
            },
            LinkComponentState::DISABLED => match ($event) {
                LinkComponentEvent::ENABLE => LinkComponentState::ENABLED,
                LinkComponentEvent::SHOW => LinkComponentState::ENABLED,
                LinkComponentEvent::RESET => LinkComponentState::ENABLED,
                default => null,
            },
            LinkComponentState::HIDDEN => match ($event) {
                LinkComponentEvent::SHOW => LinkComponentState::ENABLED,
                LinkComponentEvent::DISABLE => LinkComponentState::DISABLED,
                LinkComponentEvent::RESET => LinkComponentState::ENABLED,
                default => null,
            },
        };
    }
}