<?php

namespace yuriystank\rules\interfaces;

/**
 * Interface ValidationObjectInterface
 * @package yuriystank\rules\interfaces
 */
interface ValidationObjectInterface
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param string $message
     *
     * @return void
     */
    public function addError($message);

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return bool
     */
    public function hasErrors();
}
