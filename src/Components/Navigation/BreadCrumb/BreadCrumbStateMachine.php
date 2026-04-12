<?php

namespace W4\UI\Framework\Components\Navigation\BreadCrumb;

use RuntimeException;
use W4\UI\Framework\Components\Navigation\BreadCrumb\BreadCrumbComponentEvent;
use W4\UI\Framework\Components\Navigation\BreadCrumb\BreadCrumbComponentState;

class BreadCrumbStateMachine
{
    public function canTransition(
        BreadCrumbComponentState $from,
        BreadCrumbComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        BreadCrumbComponentState $from,
        BreadCrumbComponentEvent $event
    ): BreadCrumbComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        BreadCrumbComponentState $from,
        BreadCrumbComponentEvent $event
    ): ?BreadCrumbComponentState {
        return match ($from) {
            BreadCrumbComponentState::ENABLED => match ($event) {
                BreadCrumbComponentEvent::ACTIVATE => BreadCrumbComponentState::ACTIVE,
                BreadCrumbComponentEvent::DISABLE => BreadCrumbComponentState::DISABLED,
                BreadCrumbComponentEvent::HIDE => BreadCrumbComponentState::HIDDEN,
                BreadCrumbComponentEvent::COLLAPSE => BreadCrumbComponentState::COLLAPSED,
                BreadCrumbComponentEvent::RESET => BreadCrumbComponentState::ENABLED,
                default => null,
            },
            BreadCrumbComponentState::ACTIVE => match ($event) {
                BreadCrumbComponentEvent::DEACTIVATE => BreadCrumbComponentState::ENABLED,
                BreadCrumbComponentEvent::DISABLE => BreadCrumbComponentState::DISABLED,
                BreadCrumbComponentEvent::HIDE => BreadCrumbComponentState::HIDDEN,
                BreadCrumbComponentEvent::COLLAPSE => BreadCrumbComponentState::COLLAPSED,
                BreadCrumbComponentEvent::RESET => BreadCrumbComponentState::ENABLED,
                default => null,
            },
            BreadCrumbComponentState::DISABLED => match ($event) {
                BreadCrumbComponentEvent::ENABLE => BreadCrumbComponentState::ENABLED,
                BreadCrumbComponentEvent::SHOW => BreadCrumbComponentState::ENABLED,
                BreadCrumbComponentEvent::RESET => BreadCrumbComponentState::ENABLED,
                default => null,
            },
            BreadCrumbComponentState::HIDDEN => match ($event) {
                BreadCrumbComponentEvent::SHOW => BreadCrumbComponentState::ENABLED,
                BreadCrumbComponentEvent::DISABLE => BreadCrumbComponentState::DISABLED,
                BreadCrumbComponentEvent::RESET => BreadCrumbComponentState::ENABLED,
                default => null,
            },
            BreadCrumbComponentState::COLLAPSED => match ($event) {
                BreadCrumbComponentEvent::EXPAND => BreadCrumbComponentState::ENABLED,
                BreadCrumbComponentEvent::HIDE => BreadCrumbComponentState::HIDDEN,
                BreadCrumbComponentEvent::DISABLE => BreadCrumbComponentState::DISABLED,
                BreadCrumbComponentEvent::RESET => BreadCrumbComponentState::ENABLED,
                default => null,
            },
        };
    }
}