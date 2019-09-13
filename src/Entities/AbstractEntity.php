<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-11
 *
 */

namespace Zarei\UserAgentParser\Entities;

/**
 * Class AbstractEntity
 * @package Zarei\UserAgentParser\Entities
 */
abstract class AbstractEntity
{
    /**
     * Data setter by given array
     * @param array $array
     */
    abstract function setData(array $array) : void ;
}
