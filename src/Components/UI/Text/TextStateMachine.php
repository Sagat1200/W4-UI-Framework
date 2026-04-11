<?php

namespace W4\UiFramework\Components\UI\Text;

use RuntimeException;
use W4\UiFramework\Components\UI\Text\TextComponentEvent;
use W4\UiFramework\Components\UI\Text\TextComponentState;

class TextStateMachine
{
    public function canTransition(
        TextComponentState $from,
        TextComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        TextComponentState $from,
        TextComponentEvent $event
    ): TextComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        TextComponentState $from,
        TextComponentEvent $event
    ): ?TextComponentState {
        return match ($from) {
            TextComponentState::ENABLED => match ($event) {
                TextComponentEvent::ACTIVATE => TextComponentState::ACTIVE,
                TextComponentEvent::DISABLE => TextComponentState::DISABLED,
                TextComponentEvent::HIDE => TextComponentState::HIDDEN,
                TextComponentEvent::RESET => TextComponentState::ENABLED,
                default => null,
            },
            TextComponentState::ACTIVE => match ($event) {
                TextComponentEvent::DEACTIVATE => TextComponentState::ENABLED,
                TextComponentEvent::DISABLE => TextComponentState::DISABLED,
                TextComponentEvent::HIDE => TextComponentState::HIDDEN,
                TextComponentEvent::RESET => TextComponentState::ENABLED,
                default => null,
            },
            TextComponentState::DISABLED => match ($event) {
                TextComponentEvent::ENABLE => TextComponentState::ENABLED,
                TextComponentEvent::SHOW => TextComponentState::ENABLED,
                TextComponentEvent::RESET => TextComponentState::ENABLED,
                default => null,
            },
            TextComponentState::HIDDEN => match ($event) {
                TextComponentEvent::SHOW => TextComponentState::ENABLED,
                TextComponentEvent::DISABLE => TextComponentState::DISABLED,
                TextComponentEvent::RESET => TextComponentState::ENABLED,
                default => null,
            },
        };
    }
}
