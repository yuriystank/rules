<?php

namespace yuriystank\rules\classes\rules\string;

use yuriystank\rules\exceptions\ValidationRuleParamException;
use yuriystank\rules\interfaces\ValidationObjectInterface;

/**
 * Class EmailValidator
 * @package yuriystank\rules\classes\rules\string
 */
class SequenceRule extends StringRule
{
    const MIN_COUNT = 2;

    /**
     * @var string
     */
    private $message = 'There is a sequence of {count} or more of the same character.';

    /**
     * @var int
     */
    protected $count;

    /**
     * SequenceRule constructor.
     * @param int $count
     *
     * @throws ValidationRuleParamException
     */
    public function __construct($count = 3)
    {
        if ($count < static::MIN_COUNT) {
            throw new ValidationRuleParamException('Min count is ' . static::MIN_COUNT . '.');
        }

        $this->count = $count;
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

        if (preg_match('/(.)\1{' . ($this->count - 1) . ',}/', $validationObject->getValue())) {
            $validationObject->addError(str_replace('{count}', $this->count, $this->message));

            return false;
        }

        return true;
    }
}
