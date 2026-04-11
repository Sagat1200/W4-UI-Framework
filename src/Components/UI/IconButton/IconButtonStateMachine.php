<?php

namespace W4\UiFramework\Components\UI\IconButton;

use RuntimeException;
use W4\UiFramework\Components\UI\IconButton\IconButtonComponentEvent;
use W4\UiFramework\Components\UI\IconButton\IconButtonComponentState;

class IconButtonStateMachine
{
    public function canTransition(
        IconButtonComponentState $from,
        IconButtonComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        IconButtonComponentState $from,
        IconButtonComponentEvent $event
    ): IconButtonComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        IconButtonComponentState $from,
        IconButtonComponentEvent $event
    ): ?IconButtonComponentState {
        return match ($from) {
            IconButtonComponentState::ENABLED => match ($event) {
                IconButtonComponentEvent::CLICK => IconButtonComponentState::ACTIVE,
                IconButtonComponentEvent::DISABLE => IconButtonComponentState::DISABLED,
                IconButtonComponentEvent::START_LOADING => IconButtonComponentState::LOADING,
                IconButtonComponentEvent::SET_READONLY => IconButtonComponentState::READONLY,
                IconButtonComponentEvent::SET_ACTIVE => IconButtonComponentState::ACTIVE,
                IconButtonComponentEvent::RESET => IconButtonComponentState::ENABLED,
                default => null,
            },

            IconButtonComponentState::DISABLED => match ($event) {
                IconButtonComponentEvent::ENABLE => IconButtonComponentState::ENABLED,
                IconButtonComponentEvent::RESET => IconButtonComponentState::ENABLED,
                default => null,
            },

            IconButtonComponentState::LOADING => match ($event) {
                IconButtonComponentEvent::FINISH_LOADING => IconButtonComponentState::ENABLED,
                IconButtonComponentEvent::DISABLE => IconButtonComponentState::DISABLED,
                IconButtonComponentEvent::RESET => IconButtonComponentState::ENABLED,
                default => null,
            },

            IconButtonComponentState::READONLY => match ($event) {
                IconButtonComponentEvent::ENABLE => IconButtonComponentState::ENABLED,
                IconButtonComponentEvent::DISABLE => IconButtonComponentState::DISABLED,
                IconButtonComponentEvent::RESET => IconButtonComponentState::ENABLED,
                default => null,
            },

            IconButtonComponentState::ACTIVE => match ($event) {
                IconButtonComponentEvent::CLICK => IconButtonComponentState::ENABLED,
                IconButtonComponentEvent::ENABLE => IconButtonComponentState::ENABLED,
                IconButtonComponentEvent::DISABLE => IconButtonComponentState::DISABLED,
                IconButtonComponentEvent::START_LOADING => IconButtonComponentState::LOADING,
                IconButtonComponentEvent::RESET => IconButtonComponentState::ENABLED,
                default => null,
            },
        };
    }
}
