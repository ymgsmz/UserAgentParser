<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-09
 *
 */

namespace Zarei\UserAgentParser\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class UserAgentParser
 * @package Zarei\UserAgentParser\Facades
 * @method static \Zarei\UserAgentParser\UserAgentParser parse(string $userAgent)
 */
class UserAgentParser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'useragentparser';
    }
}
