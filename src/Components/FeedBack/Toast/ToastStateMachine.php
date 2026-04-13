<?php

namespace W4\UI\Framework\Components\FeedBack\Toast;

use RuntimeException;
use W4\UI\Framework\Components\FeedBack\Toast\ToastComponentEvent;
use W4\UI\Framework\Components\FeedBack\Toast\ToastComponentState;

class ToastStateMachine
{
    public function canTransition(
        ToastComponentState $from,
        ToastComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        ToastComponentState $from,
        ToastComponentEvent $event
    ): ToastComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        ToastComponentState $from,
        ToastComponentEvent $event
    ): ?ToastComponentState {
        return match ($from) {
            ToastComponentState::ENABLED => match ($event) {
                ToastComponentEvent::ACTIVATE => ToastComponentState::ACTIVE,
                ToastComponentEvent::DISABLE => ToastComponentState::DISABLED,
                ToastComponentEvent::HIDE => ToastComponentState::HIDDEN,
                ToastComponentEvent::DISMISS => ToastComponentState::DISMISSED,
                ToastComponentEvent::RESET => ToastComponentState::ENABLED,
                default => null,
            },
            ToastComponentState::ACTIVE => match ($event) {
                ToastComponentEvent::DEACTIVATE => ToastComponentState::ENABLED,
                ToastComponentEvent::DISABLE => ToastComponentState::DISABLED,
                ToastComponentEvent::HIDE => ToastComponentState::HIDDEN,
                ToastComponentEvent::DISMISS => ToastComponentState::DISMISSED,
                ToastComponentEvent::RESET => ToastComponentState::ENABLED,
                default => null,
            },
            ToastComponentState::DISMISSED => match ($event) {
                ToastComponentEvent::SHOW => ToastComponentState::ENABLED,
                ToastComponentEvent::RESET => ToastComponentState::ENABLED,
                default => null,
            },
            ToastComponentState::DISABLED => match ($event) {
                ToastComponentEvent::ENABLE => ToastComponentState::ENABLED,
                ToastComponentEvent::SHOW => ToastComponentState::ENABLED,
                ToastComponentEvent::RESET => ToastComponentState::ENABLED,
                default => null,
            },
            ToastComponentState::HIDDEN => match ($event) {
                ToastComponentEvent::SHOW => ToastComponentState::ENABLED,
                ToastComponentEvent::DISABLE => ToastComponentState::DISABLED,
                ToastComponentEvent::RESET => ToastComponentState::ENABLED,
                default => null,
            },
        };
    }
}
