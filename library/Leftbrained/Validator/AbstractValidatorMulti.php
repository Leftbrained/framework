<?php
namespace Leftbrained\Validator;

use Zend\Validator\AbstractValidator;

abstract class AbstractValidatorMulti extends AbstractValidator
{
    public function isValid($value)
    {
        if (!is_array($value)) {
            throw new Exception\InvalidArgumentException('Validation value must be an array');
        }

        $this->messages = array();
    }
}