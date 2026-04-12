<?php

namespace W4\UI\Framework\Support;

class ComponentId
{
    public static function generate(string $component, string $prefix = 'w4'): string
    {
        $component = trim(strtolower($component));

        return sprintf(
            '%s-%s-%s',
            $prefix,
            $component,
            substr(md5(uniqid((string) mt_rand(), true)), 0, 8)
        );
    }

    public static function fromName(string $component, string $name, string $prefix = 'w4'): string
    {
        $component = trim(strtolower($component));
        $name = trim(strtolower($name));

        $name = preg_replace('/[^a-z0-9\\-]+/', '-', $name) ?? $name;
        $name = trim($name, '-');

        return sprintf('%s-%s-%s', $prefix, $component, $name);
    }
}
