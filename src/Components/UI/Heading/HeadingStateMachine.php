<?php

namespace W4\UiFramework\Components\UI\Heading;

use RuntimeException;

class HeadingStateMachine
{
    public function canTransition(
        HeadingComponentState $from,
        HeadingComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        HeadingComponentState $from,
        HeadingComponentEvent $event
    ): HeadingComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        HeadingComponentState $from,
        HeadingComponentEvent $event
    ): ?HeadingComponentState {
        return match ($from) {
            HeadingComponentState::ENABLED => match ($event) {
                HeadingComponentEvent::ACTIVATE => HeadingComponentState::ACTIVE,
                HeadingComponentEvent::DISABLE => HeadingComponentState::DISABLED,
                HeadingComponentEvent::HIDE => HeadingComponentState::HIDDEN,
                HeadingComponentEvent::RESET => HeadingComponentState::ENABLED,
                default => null,
            },
            HeadingComponentState::ACTIVE => match ($event) {
                HeadingComponentEvent::DEACTIVATE => HeadingComponentState::ENABLED,
                HeadingComponentEvent::DISABLE => HeadingComponentState::DISABLED,
                HeadingComponentEvent::HIDE => HeadingComponentState::HIDDEN,
                HeadingComponentEvent::RESET => HeadingComponentState::ENABLED,
                default => null,
            },
            HeadingComponentState::DISABLED => match ($event) {
                HeadingComponentEvent::ENABLE => HeadingComponentState::ENABLED,
                HeadingComponentEvent::SHOW => HeadingComponentState::ENABLED,
                HeadingComponentEvent::RESET => HeadingComponentState::ENABLED,
                default => null,
            },
            HeadingComponentState::HIDDEN => match ($event) {
                HeadingComponentEvent::SHOW => HeadingComponentState::ENABLED,
                HeadingComponentEvent::DISABLE => HeadingComponentState::DISABLED,
                HeadingComponentEvent::RESET => HeadingComponentState::ENABLED,
                default => null,
            },
        };
    }
}
