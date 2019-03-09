<?php

namespace yuriystank\rules\interfaces;

/**
 * Interface ValidatorInterface
 * @package yuriystank\rules\interfaces
 */
interface ValidatorInterface
{
    /**
     * @return bool
     */
    public function validate();

    /**
     * @return ValidationRuleInterface[]
     */
    public function getValidationRules();

    /**
     * @return array
     */
    public function getValidValues();

    /**
     * @return array
     */
    public function getNotValidValues();
}
