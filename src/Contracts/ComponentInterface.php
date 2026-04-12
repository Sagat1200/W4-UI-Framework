<?php

namespace W4\UI\Framework\Contracts;

interface ComponentInterface
{
    public function componentName(): string;

    public function toThemeContext(): array;

    public function toArray(): array;
}
