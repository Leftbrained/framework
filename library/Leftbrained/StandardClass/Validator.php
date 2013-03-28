<?php
namespace Leftbrained\StandardClass;

use Zend\Validator\ValidatorInterface;

class Validator implements ValidatorInterface
{
    protected $definition;
    protected $messages;

    public function isValid($values)
    {
        $result = true;
        $messages = array();
        foreach ($this->properties as $name => $property) {
            if (!isset($values[$name])) {
                continue;
            }
            foreach ($validators as $validator) {
                if (!$validator->isValid($values[$name])) {
                    $result = false;
                    $messages[$name] = $validator->getMessages();
                }
            }
        }

        $this->abstractOptions['messages'] = $messages;
        return $result;
    }

    public function getMessages()
    {
        
    }
}