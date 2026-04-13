<?php

namespace W4\UI\Framework\Components\FeedBack\Progress;

use RuntimeException;
use W4\UI\Framework\Components\FeedBack\Progress\ProgressComponentEvent;
use W4\UI\Framework\Components\FeedBack\Progress\ProgressComponentState;

class ProgressStateMachine
{
    public function canTransition(
        ProgressComponentState $from,
        ProgressComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        ProgressComponentState $from,
        ProgressComponentEvent $event
    ): ProgressComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        ProgressComponentState $from,
        ProgressComponentEvent $event
    ): ?ProgressComponentState {
        return match ($from) {
            ProgressComponentState::ENABLED => match ($event) {
                ProgressComponentEvent::ACTIVATE => ProgressComponentState::ACTIVE,
                ProgressComponentEvent::DISABLE => ProgressComponentState::DISABLED,
                ProgressComponentEvent::HIDE => ProgressComponentState::HIDDEN,
                ProgressComponentEvent::START_LOADING => ProgressComponentState::LOADING,
                ProgressComponentEvent::SET_INDETERMINATE => ProgressComponentState::INDETERMINATE,
                ProgressComponentEvent::RESET => ProgressComponentState::ENABLED,
                default => null,
            },
            ProgressComponentState::ACTIVE => match ($event) {
                ProgressComponentEvent::DEACTIVATE => ProgressComponentState::ENABLED,
                ProgressComponentEvent::DISABLE => ProgressComponentState::DISABLED,
                ProgressComponentEvent::HIDE => ProgressComponentState::HIDDEN,
                ProgressComponentEvent::START_LOADING => ProgressComponentState::LOADING,
                ProgressComponentEvent::SET_INDETERMINATE => ProgressComponentState::INDETERMINATE,
                ProgressComponentEvent::RESET => ProgressComponentState::ENABLED,
                default => null,
            },
            ProgressComponentState::LOADING => match ($event) {
                ProgressComponentEvent::STOP_LOADING => ProgressComponentState::ENABLED,
                ProgressComponentEvent::SET_INDETERMINATE => ProgressComponentState::INDETERMINATE,
                ProgressComponentEvent::HIDE => ProgressComponentState::HIDDEN,
                ProgressComponentEvent::DISABLE => ProgressComponentState::DISABLED,
                ProgressComponentEvent::RESET => ProgressComponentState::ENABLED,
                default => null,
            },
            ProgressComponentState::INDETERMINATE => match ($event) {
                ProgressComponentEvent::SET_DETERMINATE => ProgressComponentState::ENABLED,
                ProgressComponentEvent::STOP_LOADING => ProgressComponentState::ENABLED,
                ProgressComponentEvent::HIDE => ProgressComponentState::HIDDEN,
                ProgressComponentEvent::DISABLE => ProgressComponentState::DISABLED,
                ProgressComponentEvent::RESET => ProgressComponentState::ENABLED,
                default => null,
            },
            ProgressComponentState::DISABLED => match ($event) {
                ProgressComponentEvent::ENABLE => ProgressComponentState::ENABLED,
                ProgressComponentEvent::SHOW => ProgressComponentState::ENABLED,
                ProgressComponentEvent::RESET => ProgressComponentState::ENABLED,
                default => null,
            },
            ProgressComponentState::HIDDEN => match ($event) {
                ProgressComponentEvent::SHOW => ProgressComponentState::ENABLED,
                ProgressComponentEvent::DISABLE => ProgressComponentState::DISABLED,
                ProgressComponentEvent::RESET => ProgressComponentState::ENABLED,
                default => null,
            },
        };
    }
}
