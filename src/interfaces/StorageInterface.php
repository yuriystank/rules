<?php

namespace yuriystank\rules\interfaces;

/**
 * Interface StorageInterface
 * @package yuriystank\rules\interfaces
 */
interface StorageInterface
{
    /**
     * @return array
     */
    public function getValues();

    /**
     * @param mixed $value
     * @param null $key
     *
     * @return void
     */
    public function setValue($value, $key = null);
}
