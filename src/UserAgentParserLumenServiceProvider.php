<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-20
 *
 */

namespace Zarei\UserAgentParser;


use Illuminate\Support\ServiceProvider;

class UserAgentParserLumenServiceProvider extends ServiceProvider
{
    /** {@inheritDoc} */
    public function register()
    {
        static $isFacadeRegistered = false;
        if (!$isFacadeRegistered) {
            $isFacadeRegistered = true;
            class_alias(\Zarei\UserAgentParser\UserAgentParser::class, 'useragentparser');
        }
        parent::register();
    }
}