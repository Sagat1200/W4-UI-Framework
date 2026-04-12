<?php

namespace W4\UI\Framework\Contracts;

interface ComponentThemeResolverInterface
{
    public function classes(array $context = []): array;

    public function attributes(array $context = []): array;
}
