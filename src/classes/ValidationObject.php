<?php

namespace yuriystank\rules\classes;

use yuriystank\rules\interfaces\ValidationObjectInterface;

/**
 * Class ValidationObject
 * @package yuriystank\rules\classes
 */
class ValidationObject implements ValidationObjectInterface
{
    protected $value;
    protected $errors = [];

    /**
     * ValidationObject constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $message
     */
    public function addError($message)
    {
        $this->errors[] = (string) $message;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }
}
