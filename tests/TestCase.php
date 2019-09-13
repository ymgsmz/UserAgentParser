<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-12
 *
 */
namespace Zarei\UserAgentParser\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
class TestCase extends BaseTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [\Zarei\UserAgentParser\UserAgentServiceProvider::class];
    }
}