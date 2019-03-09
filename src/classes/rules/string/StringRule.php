<?php

namespace yuriystank\rules\classes\rules\string;

use yuriystank\rules\interfaces\ValidationObjectInterface;
use yuriystank\rules\interfaces\ValidationRuleInterface;

/**
 * Class StringRule
 * @package yuriystank\rules\classes\rules\string
 */
class StringRule implements ValidationRuleInterface
{
    private $message = 'Is not a string.';

    /**
     * @param ValidationObjectInterface $validationObject
     *
     * @return bool
     */
    public function validateObject(ValidationObjectInterface $validationObject)
    {
        if (!is_string($validationObject->getValue())) {
            $this->addError($validationObject, $this->message);

            return false;
        }

        return true;
    }

    /**
     * @param ValidationObjectInterface $validationObject
     * @param string $message
     */
    protected function addError(ValidationObjectInterface $validationObject, $message)
    {
        if (!in_array($message, $validationObject->getErrors())) {
            $validationObject->addError($message);
        }
    }
}
