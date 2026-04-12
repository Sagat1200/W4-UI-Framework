<?php

namespace W4\UI\Framework\Components\FeedBack\Loading;

use RuntimeException;
use W4\UI\Framework\Components\FeedBack\Loading\LoadingComponentEvent;
use W4\UI\Framework\Components\FeedBack\Loading\LoadingComponentState;

class LoadingStateMachine
{
    public function canTransition(
        LoadingComponentState $from,
        LoadingComponentEvent $event
    ): bool {
        return $this->resolveNextState($from, $event) !== null;
    }

    public function transition(
        LoadingComponentState $from,
        LoadingComponentEvent $event
    ): LoadingComponentState {
        $next = $this->resolveNextState($from, $event);

        if ($next === null) {
            throw new RuntimeException(
                "Transaccion inválida desde estado [{$from->value}] usando evento [{$event->value}]"
            );
        }

        return $next;
    }

    protected function resolveNextState(
        LoadingComponentState $from,
        LoadingComponentEvent $event
    ): ?LoadingComponentState {
        return match ($from) {
            LoadingComponentState::ENABLED => match ($event) {
                LoadingComponentEvent::ACTIVATE => LoadingComponentState::ACTIVE,
                LoadingComponentEvent::DISABLE => LoadingComponentState::DISABLED,
                LoadingComponentEvent::HIDE => LoadingComponentState::HIDDEN,
                LoadingComponentEvent::START => LoadingComponentState::LOADING,
                LoadingComponentEvent::RESET => LoadingComponentState::ENABLED,
                default => null,
            },
            LoadingComponentState::ACTIVE => match ($event) {
                LoadingComponentEvent::DEACTIVATE => LoadingComponentState::ENABLED,
                LoadingComponentEvent::DISABLE => LoadingComponentState::DISABLED,
                LoadingComponentEvent::HIDE => LoadingComponentState::HIDDEN,
                LoadingComponentEvent::START => LoadingComponentState::LOADING,
                LoadingComponentEvent::RESET => LoadingComponentState::ENABLED,
                default => null,
            },
            LoadingComponentState::LOADING => match ($event) {
                LoadingComponentEvent::STOP => LoadingComponentState::ENABLED,
                LoadingComponentEvent::HIDE => LoadingComponentState::HIDDEN,
                LoadingComponentEvent::DISABLE => LoadingComponentState::DISABLED,
                LoadingComponentEvent::RESET => LoadingComponentState::ENABLED,
                default => null,
            },
            LoadingComponentState::DISABLED => match ($event) {
                LoadingComponentEvent::ENABLE => LoadingComponentState::ENABLED,
                LoadingComponentEvent::SHOW => LoadingComponentState::ENABLED,
                LoadingComponentEvent::RESET => LoadingComponentState::ENABLED,
                default => null,
            },
            LoadingComponentState::HIDDEN => match ($event) {
                LoadingComponentEvent::SHOW => LoadingComponentState::ENABLED,
                LoadingComponentEvent::DISABLE => LoadingComponentState::DISABLED,
                LoadingComponentEvent::RESET => LoadingComponentState::ENABLED,
                default => null,
            },
        };
    }
}