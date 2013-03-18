<?php
namespace Leftbrained\StandardClass\Validator;

use Zend\Validator\ValidatorChain;
use Leftbrained\StandardClass\StandardClass;
use Leftbrained\StandardClass\Definition;

abstract class AbstractStandardClassValidator extends ValidatorChain implements
    StandardClassValidatorInterface
{
    protected $definition;
    protected $messages = array();

    public function getDefinition()
    {
        return $this->definition;
    }

    public function setDefinition(Definition $definition)
    {
        $this->definition = $definition;
        return $this;
    }
}