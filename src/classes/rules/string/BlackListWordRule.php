<?php

namespace yuriystank\rules\classes\rules\string;

use yuriystank\rules\exceptions\ValidationRuleParamException;
use yuriystank\rules\interfaces\StorageInterface;
use yuriystank\rules\interfaces\ValidationObjectInterface;

/**
 * Class BlackListWordRule
 * @package yuriystank\rules\classes\rules\string
 */
class BlackListWordRule extends StringRule
{
    /**
     * @var string
     */
    private $message = 'Contains blacklist word "{word}".';

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * BlackListWordRule constructor.
     * @param StorageInterface $storage
     * @param array $blackListWords
     *
     * @throws ValidationRuleParamException
     */
    public function __construct(StorageInterface $storage, $blackListWords = [])
    {
        $this->storage = $storage;

        foreach ($blackListWords as $blackListWord) {
            if (!is_string($blackListWord)) {
                throw new ValidationRuleParamException($blackListWord . ' is not a string.');
            }

            $this->storage->setValue($blackListWord);
        }
    }

    /**
     * @return array
     */
    protected function getBlackListWords()
    {
        return $this->storage->getValues();
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

        foreach ($this->getBlackListWords() as $blackListWord) {
            if (strpos($validationObject->getValue(), $blackListWord) !== false) {
                $validationObject->addError(str_replace('{word}', $blackListWord, $this->message));

                return false;
            }
        }

        return true;
    }
}
