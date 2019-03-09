<?php

namespace yuriystank\rules;

use yuriystank\rules\classes\rules\string\BlackListDomainRule;
use yuriystank\rules\classes\rules\string\BlackListWordRule;
use yuriystank\rules\classes\rules\string\EmailRule;
use yuriystank\rules\classes\rules\string\RegexpRule;
use yuriystank\rules\classes\rules\string\SequenceRule;
use yuriystank\rules\classes\Storage;
use yuriystank\rules\classes\Validator;
use \PHPUnit\Framework\TestCase;

/**
 * Class ValidatorTest
 * @package yuriystank\rules
 */
class ValidatorTest extends TestCase
{
    public function testEmails()
    {
        $blacklistDomains = ['mail.ru', 'yandex.ru', 'spam.com', 'test.io', 'dev.com'];
        $blacklistWords = ['wft', 'bad', 'stuff', 'test', 'dev'];
        $validEmails = [
            'yuriystank@gmail.com',
            'someName@yahoo.com',
            '123@bing.com',
            'some@mail.io',
            'someEmailAddr@dom.com',
            'rules@gmail.com',
            'skeleton@gmail.com',
        ];

        $notValidEmails = [
            'yuriystank@',
            'yuriystank@mail.ru',
            'wft@gmail.com',
            'yuriy stank@mail.ru',
            'qqq@gmail.com',
            'testMail@dom.com',
            '222222@gmail.com',
            'stuffEmail@gmail.com',
            'stuff***Email@gmail.com',
        ];

        $validator = new Validator(new Storage());
        $validator->setValidationRule(new EmailRule());
        $validator->setValidationRule(new BlackListWordRule(new Storage(), $blacklistWords));
        $validator->setValidationRule(new BlackListDomainRule(new Storage(), $blacklistDomains));
        $validator->setValidationRule(new RegexpRule('/^[a-zA-Z0-9@.]*$/'));
        $validator->setValidationRule(new SequenceRule());
        $validator->setValues(array_merge($validEmails, $notValidEmails));
        $hasNoErrors = $validator->validate();

        $this->assertEquals(false, $hasNoErrors);
        $this->assertEquals($validEmails, $validator->getValidValues());
        $this->assertEquals($notValidEmails, $validator->getNotValidValues());

        $valuesErrors = $validator->getErrors();

        $this->assertEquals($notValidEmails, array_keys($valuesErrors));
        $this->assertEquals(true, isset($valuesErrors['yuriystank@']));
        $this->assertEquals('Is not a valid email address.', $valuesErrors['yuriystank@'][0]);
    }
}
