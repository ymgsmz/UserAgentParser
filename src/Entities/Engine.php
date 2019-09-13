<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-12
 *
 */

namespace Zarei\UserAgentParser\Entities;


use Zarei\UserAgentParser\Traits\MajorVersion;

/**
 * Class Engine
 * @package Zarei\UserAgentParser\Entities
 */
class Engine extends AbstractEntity
{
    use MajorVersion;

    /** @var string */
    public $name;

    /** @var string */
    public $version;

    /** {@inheritdoc} */
    public function setData(array $array): void
    {
        foreach ($array as $key => $value) {
            switch ($key) {
                case 'name':
                    $this->setName($value);
                    break;
                case 'version':
                    $this->setVersion($value);
                    break;
            }
        }
    }

    /**
     * Set name value.
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Set version value.
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
        $this->setMajor();
    }
}
