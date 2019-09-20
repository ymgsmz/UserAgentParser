<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-08
 *
 */

namespace Zarei\UserAgentParser;


use Illuminate\Support\ServiceProvider;

/**
 * Class UserAgentServiceProvider
 * @package Zarei\UserAgentParser
 */
class UserAgentServiceProvider extends ServiceProvider
{
    /** {@inheritDoc} */
    public function register()
    {
        $this->app->bind('useragentparser', UserAgentParser::class);
    }

    /** {@inheritDoc} */
    public function provides()
    {
        return ['useragentparser'];
    }
}
