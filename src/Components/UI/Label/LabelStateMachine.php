<?php

namespace W4\UiFramework\Components\UI\Label;

use RuntimeException;
use W4\UiFramework\Components\UI\Label\LabelComponentEvent;
use W4\UiFramework\Components\UI\Label\LabelComponentState;

class LabelStateMachine
{
    public function canTransition(
        LabelComponentState $from,
        LabelComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        LabelComponentState $from,
        LabelComponentEvent $event
    ): LabelComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        LabelComponentState $from,
        LabelComponentEvent $event
    ): ?LabelComponentState {
        return match ($from) {
            LabelComponentState::ENABLED => match ($event) {
                LabelComponentEvent::ACTIVATE => LabelComponentState::ACTIVE,
                LabelComponentEvent::DISABLE => LabelComponentState::DISABLED,
                LabelComponentEvent::HIDE => LabelComponentState::HIDDEN,
                LabelComponentEvent::RESET => LabelComponentState::ENABLED,
                default => null,
            },
            LabelComponentState::ACTIVE => match ($event) {
                LabelComponentEvent::DEACTIVATE => LabelComponentState::ENABLED,
                LabelComponentEvent::DISABLE => LabelComponentState::DISABLED,
                LabelComponentEvent::HIDE => LabelComponentState::HIDDEN,
                LabelComponentEvent::RESET => LabelComponentState::ENABLED,
                default => null,
            },
            LabelComponentState::DISABLED => match ($event) {
                LabelComponentEvent::ENABLE => LabelComponentState::ENABLED,
                LabelComponentEvent::SHOW => LabelComponentState::ENABLED,
                LabelComponentEvent::RESET => LabelComponentState::ENABLED,
                default => null,
            },
            LabelComponentState::HIDDEN => match ($event) {
                LabelComponentEvent::SHOW => LabelComponentState::ENABLED,
                LabelComponentEvent::DISABLE => LabelComponentState::DISABLED,
                LabelComponentEvent::RESET => LabelComponentState::ENABLED,
                default => null,
            },
        };
    }
}
