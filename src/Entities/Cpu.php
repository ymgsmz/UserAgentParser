<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-12
 *
 */

namespace Zarei\UserAgentParser\Entities;

/**
 * Class Cpu
 * @package Zarei\UserAgentParser\Entities
 */
class Cpu extends AbstractEntity
{
    /** @var string */
    public $architecture;

    /** {@inheritdoc} */
    public function setData(array $array): void
    {
        foreach ($array as $key => $value) {
            switch ($key) {
                case 'architecture':
                    $this->setArchitecture($value);
                    break;
            }
        }
    }

    /**
     * Set architecture value.
     * @param string $architecture
     */
    public function setArchitecture(string $architecture): void
    {
        $this->architecture = $architecture;
    }
}
