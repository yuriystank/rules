<?php

namespace yuriystank\rules\classes\rules\string;

use yuriystank\rules\interfaces\ValidationObjectInterface;

/**
 * Class RegexpRule
 * @package yuriystank\rules\classes\rules\string
 */
class RegexpRule extends StringRule
{
    /**
     * @var string
     */
    private $message = 'Value not matches regexp "{regexp}".';

    /**
     * @var string
     */
    protected $regexp;

    /**
     * RegexpRule constructor.
     * @param string $regexp
     */
    public function __construct($regexp)
    {
        $this->regexp = $regexp;
    }

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

        if (!preg_match($this->regexp, $validationObject->getValue())) {
            $validationObject->addError(str_replace('{regexp}', $this->regexp, $this->message));

            return false;
        }

        return true;
    }
}
