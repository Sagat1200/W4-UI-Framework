<?php

namespace W4\UI\Framework\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use W4\UI\Framework\Providers\W4UIFrameworkServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            W4UIFrameworkServiceProvider::class,
        ];
    }
}
