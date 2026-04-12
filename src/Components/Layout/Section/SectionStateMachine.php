<?php

namespace W4\UI\Framework\Components\Layout\Section;

use RuntimeException;
use W4\UI\Framework\Components\Layout\Section\SectionComponentEvent;
use W4\UI\Framework\Components\Layout\Section\SectionComponentState;

class SectionStateMachine
{
    public function canTransition(
        SectionComponentState $from,
        SectionComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        SectionComponentState $from,
        SectionComponentEvent $event
    ): SectionComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        SectionComponentState $from,
        SectionComponentEvent $event
    ): ?SectionComponentState {
        return match ($from) {
            SectionComponentState::ENABLED => match ($event) {
                SectionComponentEvent::ACTIVATE => SectionComponentState::ACTIVE,
                SectionComponentEvent::DISABLE => SectionComponentState::DISABLED,
                SectionComponentEvent::HIDE => SectionComponentState::HIDDEN,
                SectionComponentEvent::COLLAPSE => SectionComponentState::COLLAPSED,
                SectionComponentEvent::RESET => SectionComponentState::ENABLED,
                default => null,
            },
            SectionComponentState::ACTIVE => match ($event) {
                SectionComponentEvent::DEACTIVATE => SectionComponentState::ENABLED,
                SectionComponentEvent::DISABLE => SectionComponentState::DISABLED,
                SectionComponentEvent::HIDE => SectionComponentState::HIDDEN,
                SectionComponentEvent::COLLAPSE => SectionComponentState::COLLAPSED,
                SectionComponentEvent::RESET => SectionComponentState::ENABLED,
                default => null,
            },
            SectionComponentState::DISABLED => match ($event) {
                SectionComponentEvent::ENABLE => SectionComponentState::ENABLED,
                SectionComponentEvent::SHOW => SectionComponentState::ENABLED,
                SectionComponentEvent::RESET => SectionComponentState::ENABLED,
                default => null,
            },
            SectionComponentState::HIDDEN => match ($event) {
                SectionComponentEvent::SHOW => SectionComponentState::ENABLED,
                SectionComponentEvent::DISABLE => SectionComponentState::DISABLED,
                SectionComponentEvent::RESET => SectionComponentState::ENABLED,
                default => null,
            },
            SectionComponentState::COLLAPSED => match ($event) {
                SectionComponentEvent::EXPAND => SectionComponentState::ENABLED,
                SectionComponentEvent::HIDE => SectionComponentState::HIDDEN,
                SectionComponentEvent::DISABLE => SectionComponentState::DISABLED,
                SectionComponentEvent::RESET => SectionComponentState::ENABLED,
                default => null,
            },
        };
    }
}