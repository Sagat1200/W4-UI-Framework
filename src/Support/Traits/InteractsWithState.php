<?php

namespace W4\UI\Framework\Support\Traits;

trait InteractsWithState
{
    protected mixed $state = null;

    public function state(mixed $state = null): mixed
    {
        if (func_num_args() === 0) {
            return $this->state;
        }

        $this->state = $state;

        return $this;
    }

    public function hasState(): bool
    {
        return $this->state !== null;
    }

    public function stateValue(): mixed
    {
        if (is_object($this->state) && property_exists($this->state, 'value')) {
            return $this->state->value;
        }

        if ($this->state instanceof \BackedEnum) {
            return $this->state->value;
        }

        return $this->state;
    }

    public function isState(mixed $state): bool
    {
        $current = $this->stateValue();

        if ($state instanceof \BackedEnum) {
            return $current === $state->value;
        }

        if (is_object($state) && property_exists($state, 'value')) {
            return $current === $state->value;
        }

        return $current === $state;
    }
}
