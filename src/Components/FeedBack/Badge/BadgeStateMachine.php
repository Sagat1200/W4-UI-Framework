<?php

namespace W4\UiFramework\Components\FeedBack\Badge;

use RuntimeException;
use W4\UiFramework\Components\FeedBack\Badge\BadgeComponentEvent;
use W4\UiFramework\Components\FeedBack\Badge\BadgeComponentState;

class BadgeStateMachine
{
    public function canTransition(
        BadgeComponentState $from,
        BadgeComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        BadgeComponentState $from,
        BadgeComponentEvent $event
    ): BadgeComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        BadgeComponentState $from,
        BadgeComponentEvent $event
    ): ?BadgeComponentState {
        return match ($from) {
            BadgeComponentState::ENABLED => match ($event) {
                BadgeComponentEvent::ACTIVATE => BadgeComponentState::ACTIVE,
                BadgeComponentEvent::DISABLE => BadgeComponentState::DISABLED,
                BadgeComponentEvent::HIDE => BadgeComponentState::HIDDEN,
                BadgeComponentEvent::HIGHLIGHT => BadgeComponentState::HIGHLIGHTED,
                BadgeComponentEvent::RESET => BadgeComponentState::ENABLED,
                default => null,
            },
            BadgeComponentState::ACTIVE => match ($event) {
                BadgeComponentEvent::DEACTIVATE => BadgeComponentState::ENABLED,
                BadgeComponentEvent::DISABLE => BadgeComponentState::DISABLED,
                BadgeComponentEvent::HIDE => BadgeComponentState::HIDDEN,
                BadgeComponentEvent::HIGHLIGHT => BadgeComponentState::HIGHLIGHTED,
                BadgeComponentEvent::RESET => BadgeComponentState::ENABLED,
                default => null,
            },
            BadgeComponentState::HIGHLIGHTED => match ($event) {
                BadgeComponentEvent::NORMALIZE => BadgeComponentState::ENABLED,
                BadgeComponentEvent::HIDE => BadgeComponentState::HIDDEN,
                BadgeComponentEvent::DISABLE => BadgeComponentState::DISABLED,
                BadgeComponentEvent::RESET => BadgeComponentState::ENABLED,
                default => null,
            },
            BadgeComponentState::DISABLED => match ($event) {
                BadgeComponentEvent::ENABLE => BadgeComponentState::ENABLED,
                BadgeComponentEvent::SHOW => BadgeComponentState::ENABLED,
                BadgeComponentEvent::RESET => BadgeComponentState::ENABLED,
                default => null,
            },
            BadgeComponentState::HIDDEN => match ($event) {
                BadgeComponentEvent::SHOW => BadgeComponentState::ENABLED,
                BadgeComponentEvent::DISABLE => BadgeComponentState::DISABLED,
                BadgeComponentEvent::RESET => BadgeComponentState::ENABLED,
                default => null,
            },
        };
    }
}
