<?php

namespace yuriystank\rules\classes\rules\string;

use yuriystank\rules\exceptions\ValidationRuleParamException;
use yuriystank\rules\interfaces\StorageInterface;
use yuriystank\rules\interfaces\ValidationObjectInterface;

/**
 * Class BlackListDomainRule
 * @package yuriystank\rules\classes\rules\string
 */
class BlackListDomainRule extends StringRule
{
    /**
     * @var string
     */
    private $message = 'Contains blacklist domain "{domain}".';

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * BlackListDomainRule constructor.
     * @param StorageInterface $storage
     * @param array $blackListDomains
     *
     * @throws ValidationRuleParamException
     */
    public function __construct(StorageInterface $storage, $blackListDomains = [])
    {
        $this->storage = $storage;

        foreach ($blackListDomains as $blackListDomain) {
            if (is_string($blackListDomain)) {
                if (!static::isValidDomainName($blackListDomain)) {
                    throw new ValidationRuleParamException($blackListDomain . ' is not a valid domain.');
                }

                $this->storage->setValue($blackListDomain);
            }
        }
    }

    /**
     * @return array
     */
    protected function getBlackListDomains()
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
        foreach ($this->getBlackListDomains() as $blackListDomain) {
            if ($blackListDomain === static::getDomain($validationObject->getValue())) {
                $validationObject->addError(str_replace('{domain}', $blackListDomain, $this->message));

                return false;
            }
        }

        return true;
    }

    /**
     * @param string $email
     *
     * @return string
     */
    protected static function getDomain($email)
    {
        return substr(strrchr($email, "@"), 1);
    }


    /**
     * May use filter_var($domain, FILTER_VALIDATE_DOMAIN) in php7
     *
     * @param string $domain
     *
     * @return bool
     */
    protected static function isValidDomainName($domain)
    {
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain)
            && preg_match("/^.{1,253}$/", $domain)
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain)   );
    }
}
