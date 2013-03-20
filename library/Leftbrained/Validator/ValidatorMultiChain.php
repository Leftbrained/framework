<?php
namespace Leftbrained\Validator;

use Zend\Validator\ValidatorChain as BaseClass;
use Leftbrained\StandardClass\Definition;
use Leftbrained\StandardClass\Exception;

class ValidatorMultiChain extends BaseClass implements
    ValidatorMultiInterface
{

    public function attach(ValidatorMultiInterface $validator, $breakChainOnFailure = false)
    {
        return parent::attach($validator, $breakChainOnFailure);
    }

    public function isValid($value, $context = null)
    {
        if (!is_array($value)) {
            throw new Exception\InvalidArgumentException('Validation Multi value must be an array');
        }

        return parent::isValid($value, $context);
    }
}