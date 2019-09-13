<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-12
 *
 */

namespace Zarei\UserAgentParser\Traits;

/**
 * Trait MajorVersion
 * @package Zarei\UserAgentParser\Traits
 */
trait MajorVersion
{
    /** @var int */
    public $major;

    /**
     * Set the value of major version.
     */
    protected function setMajor(): void
    {
        $splitVersion = explode('.', preg_replace('/[^\d\.]/', '', $this->version));
        $this->major = $splitVersion[0];
    }
}
