<?php

namespace yuriystank\rules\interfaces;

/**
 * Interface ValidationRuleInterface
 * @package yuriystank\rules\interfaces
 */
interface ValidationRuleInterface
{
    /**
     * @param ValidationObjectInterface $value
     *
     * @return bool
     */
    public function validateObject(ValidationObjectInterface $value);
}
