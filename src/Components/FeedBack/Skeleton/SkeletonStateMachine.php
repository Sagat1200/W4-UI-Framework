<?php

namespace W4\UI\Framework\Components\FeedBack\Skeleton;

use RuntimeException;
use W4\UI\Framework\Components\FeedBack\Skeleton\SkeletonComponentEvent;
use W4\UI\Framework\Components\FeedBack\Skeleton\SkeletonComponentState;

class SkeletonStateMachine
{
    public function canTransition(
        SkeletonComponentState $from,
        SkeletonComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        SkeletonComponentState $from,
        SkeletonComponentEvent $event
    ): SkeletonComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        SkeletonComponentState $from,
        SkeletonComponentEvent $event
    ): ?SkeletonComponentState {
        return match ($from) {
            SkeletonComponentState::ENABLED => match ($event) {
                SkeletonComponentEvent::ACTIVATE => SkeletonComponentState::ACTIVE,
                SkeletonComponentEvent::DISABLE => SkeletonComponentState::DISABLED,
                SkeletonComponentEvent::HIDE => SkeletonComponentState::HIDDEN,
                SkeletonComponentEvent::START_LOADING => SkeletonComponentState::LOADING,
                SkeletonComponentEvent::RESET => SkeletonComponentState::ENABLED,
                default => null,
            },
            SkeletonComponentState::ACTIVE => match ($event) {
                SkeletonComponentEvent::DEACTIVATE => SkeletonComponentState::ENABLED,
                SkeletonComponentEvent::DISABLE => SkeletonComponentState::DISABLED,
                SkeletonComponentEvent::HIDE => SkeletonComponentState::HIDDEN,
                SkeletonComponentEvent::START_LOADING => SkeletonComponentState::LOADING,
                SkeletonComponentEvent::RESET => SkeletonComponentState::ENABLED,
                default => null,
            },
            SkeletonComponentState::LOADING => match ($event) {
                SkeletonComponentEvent::STOP_LOADING => SkeletonComponentState::ENABLED,
                SkeletonComponentEvent::HIDE => SkeletonComponentState::HIDDEN,
                SkeletonComponentEvent::DISABLE => SkeletonComponentState::DISABLED,
                SkeletonComponentEvent::RESET => SkeletonComponentState::ENABLED,
                default => null,
            },
            SkeletonComponentState::DISABLED => match ($event) {
                SkeletonComponentEvent::ENABLE => SkeletonComponentState::ENABLED,
                SkeletonComponentEvent::SHOW => SkeletonComponentState::ENABLED,
                SkeletonComponentEvent::RESET => SkeletonComponentState::ENABLED,
                default => null,
            },
            SkeletonComponentState::HIDDEN => match ($event) {
                SkeletonComponentEvent::SHOW => SkeletonComponentState::ENABLED,
                SkeletonComponentEvent::DISABLE => SkeletonComponentState::DISABLED,
                SkeletonComponentEvent::RESET => SkeletonComponentState::ENABLED,
                default => null,
            },
        };
    }
}
