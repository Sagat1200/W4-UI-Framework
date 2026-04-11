<?php

namespace W4\UiFramework\Components\Layout\Panel;

use RuntimeException;
use W4\UiFramework\Components\Layout\Panel\PanelComponentEvent;
use W4\UiFramework\Components\Layout\Panel\PanelComponentState;

class PanelStateMachine
{
    public function canTransition(
        PanelComponentState $from,
        PanelComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        PanelComponentState $from,
        PanelComponentEvent $event
    ): PanelComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        PanelComponentState $from,
        PanelComponentEvent $event
    ): ?PanelComponentState {
        return match ($from) {
            PanelComponentState::ENABLED => match ($event) {
                PanelComponentEvent::ACTIVATE => PanelComponentState::ACTIVE,
                PanelComponentEvent::DISABLE => PanelComponentState::DISABLED,
                PanelComponentEvent::HIDE => PanelComponentState::HIDDEN,
                PanelComponentEvent::COLLAPSE => PanelComponentState::COLLAPSED,
                PanelComponentEvent::RESET => PanelComponentState::ENABLED,
                default => null,
            },
            PanelComponentState::ACTIVE => match ($event) {
                PanelComponentEvent::DEACTIVATE => PanelComponentState::ENABLED,
                PanelComponentEvent::DISABLE => PanelComponentState::DISABLED,
                PanelComponentEvent::HIDE => PanelComponentState::HIDDEN,
                PanelComponentEvent::COLLAPSE => PanelComponentState::COLLAPSED,
                PanelComponentEvent::RESET => PanelComponentState::ENABLED,
                default => null,
            },
            PanelComponentState::DISABLED => match ($event) {
                PanelComponentEvent::ENABLE => PanelComponentState::ENABLED,
                PanelComponentEvent::SHOW => PanelComponentState::ENABLED,
                PanelComponentEvent::RESET => PanelComponentState::ENABLED,
                default => null,
            },
            PanelComponentState::HIDDEN => match ($event) {
                PanelComponentEvent::SHOW => PanelComponentState::ENABLED,
                PanelComponentEvent::DISABLE => PanelComponentState::DISABLED,
                PanelComponentEvent::RESET => PanelComponentState::ENABLED,
                default => null,
            },
            PanelComponentState::COLLAPSED => match ($event) {
                PanelComponentEvent::EXPAND => PanelComponentState::ENABLED,
                PanelComponentEvent::HIDE => PanelComponentState::HIDDEN,
                PanelComponentEvent::DISABLE => PanelComponentState::DISABLED,
                PanelComponentEvent::RESET => PanelComponentState::ENABLED,
                default => null,
            },
        };
    }
}
