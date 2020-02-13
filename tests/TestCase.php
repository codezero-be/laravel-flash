<?php

namespace CodeZero\Flash\Tests;

use CodeZero\Flash\FlashServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Get the packages service providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FlashServiceProvider::class,
        ];
    }
}
