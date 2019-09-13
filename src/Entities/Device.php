<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-12
 *
 */

namespace Zarei\UserAgentParser\Entities;

/**
 * Class Device
 * @package Zarei\UserAgentParser\Entities
 */
class Device extends AbstractEntity
{
    /** @var string */
    public $vendor;

    /** @var string */
    public $model;

    /** @var string */
    public $type;

    /** {@inheritdoc} */
    public function setData(array $array) : void
    {
        foreach ($array as $key => $value) {
            switch ($key) {
                case 'vendor':
                    $this->setVendor($value);
                    break;
                case 'model':
                    $this->setModel($value);
                    break;
                case 'type':
                    $this->setType($value);
                    break;
            }
        }
    }

    /**
     * Set model value.
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * Set type value.
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Set vendor value.
     * @param string $vendor
     */
    public function setVendor(string $vendor): void
    {
        $this->vendor = $vendor;
    }
}
