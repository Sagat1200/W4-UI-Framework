<?php

namespace W4\UiFramework\Components\Interactive\Tooltip;

use RuntimeException;
use W4\UiFramework\Components\Interactive\Tooltip\TooltipComponentEvent;
use W4\UiFramework\Components\Interactive\Tooltip\TooltipComponentState;

class TooltipStateMachine
{
    public function canTransition(
        TooltipComponentState $from,
        TooltipComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        TooltipComponentState $from,
        TooltipComponentEvent $event
    ): TooltipComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        TooltipComponentState $from,
        TooltipComponentEvent $event
    ): ?TooltipComponentState {
        return match ($from) {
            TooltipComponentState::ENABLED => match ($event) {
                TooltipComponentEvent::ACTIVATE => TooltipComponentState::ACTIVE,
                TooltipComponentEvent::DISABLE => TooltipComponentState::DISABLED,
                TooltipComponentEvent::HIDE => TooltipComponentState::HIDDEN,
                TooltipComponentEvent::OPEN => TooltipComponentState::OPEN,
                TooltipComponentEvent::TOGGLE => TooltipComponentState::OPEN,
                TooltipComponentEvent::RESET => TooltipComponentState::ENABLED,
                default => null,
            },
            TooltipComponentState::ACTIVE => match ($event) {
                TooltipComponentEvent::DEACTIVATE => TooltipComponentState::ENABLED,
                TooltipComponentEvent::DISABLE => TooltipComponentState::DISABLED,
                TooltipComponentEvent::HIDE => TooltipComponentState::HIDDEN,
                TooltipComponentEvent::OPEN => TooltipComponentState::OPEN,
                TooltipComponentEvent::TOGGLE => TooltipComponentState::OPEN,
                TooltipComponentEvent::RESET => TooltipComponentState::ENABLED,
                default => null,
            },
            TooltipComponentState::OPEN => match ($event) {
                TooltipComponentEvent::CLOSE => TooltipComponentState::ENABLED,
                TooltipComponentEvent::TOGGLE => TooltipComponentState::ENABLED,
                TooltipComponentEvent::HIDE => TooltipComponentState::HIDDEN,
                TooltipComponentEvent::DISABLE => TooltipComponentState::DISABLED,
                TooltipComponentEvent::RESET => TooltipComponentState::ENABLED,
                default => null,
            },
            TooltipComponentState::DISABLED => match ($event) {
                TooltipComponentEvent::ENABLE => TooltipComponentState::ENABLED,
                TooltipComponentEvent::SHOW => TooltipComponentState::ENABLED,
                TooltipComponentEvent::RESET => TooltipComponentState::ENABLED,
                default => null,
            },
            TooltipComponentState::HIDDEN => match ($event) {
                TooltipComponentEvent::SHOW => TooltipComponentState::ENABLED,
                TooltipComponentEvent::DISABLE => TooltipComponentState::DISABLED,
                TooltipComponentEvent::RESET => TooltipComponentState::ENABLED,
                default => null,
            },
        };
    }
}
