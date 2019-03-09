<?php

namespace yuriystank\rules\classes\rules\string;

use yuriystank\rules\interfaces\ValidationObjectInterface;

/**
 * Class EmailRule
 * @package yuriystank\rules\classes\rules\string
 */
class EmailRule extends StringRule
{
    private $message = 'Is not a valid email address.';

    /**
     * @param ValidationObjectInterface $validationObject
     *
     * @return bool
     */
    public function validateObject(ValidationObjectInterface $validationObject)
    {
        if (!parent::validateObject($validationObject)) {
            return false;
        }

        if (!filter_var($validationObject->getValue(), FILTER_VALIDATE_EMAIL)) {
            $validationObject->addError($this->message);

            return false;
        }

        return true;
    }
}
