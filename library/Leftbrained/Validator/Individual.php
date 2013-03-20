<?php
namespace Leftbrained\Validator;

use Zend\Validator\ValidatorInterface;

class Individual implements ValidatorMultiInterface
{
    protected $properties = array();
    protected $messages;

    public function attach($name, ValidatorInterface $validator)
    {
        if (!isset($this->properties[$name])) {
            $this->properties[$name] = array();
        }
        $this->properties[$name][] = $validator;
        return $this;
    }

    public function isValid($values)
    {
        $result = true;
        $messages = array();
        foreach ($this->properties as $name => $validators) {
            if (!isset($values[$name])) {
                continue;
            }
            foreach ($validators as $validator) {
                if (!$validator->isValid($values[$name])) {
                    $result = false;
                    $this->messages[$name] = $validator->getMessages();
                }
            }
        }

        $this->messages = $messages;
        return $result;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}