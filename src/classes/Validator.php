<?php

namespace yuriystank\rules\classes;

use yuriystank\rules\interfaces\StorageInterface;
use yuriystank\rules\interfaces\ValidationRuleInterface;
use yuriystank\rules\interfaces\ValidatorInterface;

/**
 * Class Validator
 * @package yuriystank\rules\classes
 */
class Validator implements ValidatorInterface
{
    protected $validationRules = [];
    protected $storage;

    /**
     * StringValidator constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param array $values
     */
    public function setValues(array $values)
    {
        foreach ($values as $value) {
            $this->storage->setValue(new ValidationObject($value));
        }
    }

    /**
     * @return ValidationObject[]
     */
    protected function getValues()
    {
        return $this->storage->getValues();
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        $result = [];

        foreach ($this->getValues() as $validationObject) {
            if ($validationObject->hasErrors()) {
                $result[$validationObject->getValue()] = $validationObject->getErrors();
            }
        }

        return $result;
    }

    /**
     * @param ValidationRuleInterface $rule
     */
    public function setValidationRule(ValidationRuleInterface $rule)
    {
        $this->validationRules[] = $rule;
    }

    /**
     * @return ValidationRuleInterface[]
     */
    public function getValidationRules()
    {
        return $this->validationRules;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $result = true;

        foreach ($this->getValues() as $value) {
            foreach ($this->getValidationRules() as $rule) {
                $rule->validateObject($value);

                if ($value->hasErrors()) {
                    $result = false;
                }
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        $result = [];

        foreach ($this->getValues() as $value) {
            if (!$value->hasErrors()) {
                $result[] = $value->getValue();
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getNotValidValues()
    {
        $result = [];

        foreach ($this->getValues() as $value) {
            if ($value->hasErrors()) {
                $result[] = $value->getValue();
            }
        }

        return $result;
    }
}
