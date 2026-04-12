<?php

namespace W4\UI\Framework\Components\Layout\Card;

use RuntimeException;
use W4\UI\Framework\Components\Layout\Card\CardComponentEvent;
use W4\UI\Framework\Components\Layout\Card\CardComponentState;

class CardStateMachine
{
    public function canTransition(
        CardComponentState $from,
        CardComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        CardComponentState $from,
        CardComponentEvent $event
    ): CardComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        CardComponentState $from,
        CardComponentEvent $event
    ): ?CardComponentState {
        return match ($from) {
            CardComponentState::ENABLED => match ($event) {
                CardComponentEvent::ACTIVATE => CardComponentState::ACTIVE,
                CardComponentEvent::DISABLE => CardComponentState::DISABLED,
                CardComponentEvent::HIDE => CardComponentState::HIDDEN,
                CardComponentEvent::COLLAPSE => CardComponentState::COLLAPSED,
                CardComponentEvent::RESET => CardComponentState::ENABLED,
                default => null,
            },
            CardComponentState::ACTIVE => match ($event) {
                CardComponentEvent::DEACTIVATE => CardComponentState::ENABLED,
                CardComponentEvent::DISABLE => CardComponentState::DISABLED,
                CardComponentEvent::HIDE => CardComponentState::HIDDEN,
                CardComponentEvent::COLLAPSE => CardComponentState::COLLAPSED,
                CardComponentEvent::RESET => CardComponentState::ENABLED,
                default => null,
            },
            CardComponentState::DISABLED => match ($event) {
                CardComponentEvent::ENABLE => CardComponentState::ENABLED,
                CardComponentEvent::SHOW => CardComponentState::ENABLED,
                CardComponentEvent::RESET => CardComponentState::ENABLED,
                default => null,
            },
            CardComponentState::HIDDEN => match ($event) {
                CardComponentEvent::SHOW => CardComponentState::ENABLED,
                CardComponentEvent::DISABLE => CardComponentState::DISABLED,
                CardComponentEvent::RESET => CardComponentState::ENABLED,
                default => null,
            },
            CardComponentState::COLLAPSED => match ($event) {
                CardComponentEvent::EXPAND => CardComponentState::ENABLED,
                CardComponentEvent::HIDE => CardComponentState::HIDDEN,
                CardComponentEvent::DISABLE => CardComponentState::DISABLED,
                CardComponentEvent::RESET => CardComponentState::ENABLED,
                default => null,
            },
        };
    }
}