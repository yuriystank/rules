<?php

namespace yuriystank\rules\classes;

use yuriystank\rules\interfaces\StorageInterface;

/**
 * Class Storage
 * @package yuriystank\rules\classes
 */
class Storage implements StorageInterface
{
    protected $values = [];

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param mixed $value
     *
     * @param null $key
     */
    public function setValue($value, $key = null)
    {
        if ($key !== null) {
            $this->values[$key] = $value;
        } else {
            $this->values[] = $value;
        }
    }
}
