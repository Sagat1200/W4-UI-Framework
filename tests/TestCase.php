<?php

namespace W4\UiFramework\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use W4\UiFramework\Providers\W4UiFrameworkServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            W4UiFrameworkServiceProvider::class,
        ];
    }
}
