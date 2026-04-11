<?php

namespace W4\UiFramework\Components\Layout\Divider;

use RuntimeException;
use W4\UiFramework\Components\Layout\Divider\DividerComponentEvent;
use W4\UiFramework\Components\Layout\Divider\DividerComponentState;

class DividerStateMachine
{
    public function canTransition(
        DividerComponentState $from,
        DividerComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        DividerComponentState $from,
        DividerComponentEvent $event
    ): DividerComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        DividerComponentState $from,
        DividerComponentEvent $event
    ): ?DividerComponentState {
        return match ($from) {
            DividerComponentState::ENABLED => match ($event) {
                DividerComponentEvent::ACTIVATE => DividerComponentState::ACTIVE,
                DividerComponentEvent::DISABLE => DividerComponentState::DISABLED,
                DividerComponentEvent::HIDE => DividerComponentState::HIDDEN,
                DividerComponentEvent::RESET => DividerComponentState::ENABLED,
                default => null,
            },
            DividerComponentState::ACTIVE => match ($event) {
                DividerComponentEvent::DEACTIVATE => DividerComponentState::ENABLED,
                DividerComponentEvent::DISABLE => DividerComponentState::DISABLED,
                DividerComponentEvent::HIDE => DividerComponentState::HIDDEN,
                DividerComponentEvent::RESET => DividerComponentState::ENABLED,
                default => null,
            },
            DividerComponentState::DISABLED => match ($event) {
                DividerComponentEvent::ENABLE => DividerComponentState::ENABLED,
                DividerComponentEvent::SHOW => DividerComponentState::ENABLED,
                DividerComponentEvent::RESET => DividerComponentState::ENABLED,
                default => null,
            },
            DividerComponentState::HIDDEN => match ($event) {
                DividerComponentEvent::SHOW => DividerComponentState::ENABLED,
                DividerComponentEvent::DISABLE => DividerComponentState::DISABLED,
                DividerComponentEvent::RESET => DividerComponentState::ENABLED,
                default => null,
            },
        };
    }
}
