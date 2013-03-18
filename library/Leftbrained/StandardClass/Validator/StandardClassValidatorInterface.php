<?php
namespace Leftbrained\StandardClass\Validator;

use Zend\Validator\ValidatorInterface;
use Leftbrained\StandardClass\Definition;

interface StandardClassValidatorInterface extends ValidatorInterface
{
    public function getDefinition();

    public function setDefinition(Definition $instance);
}