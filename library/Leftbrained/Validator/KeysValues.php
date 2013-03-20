<?php
namespace Leftbrained\Validator;

use Zend\Validator\ValidatorInterface;

class KeysValues extends AbstractValidatorMulti
{
    protected $keysValues = array();

    public function attach($name, ValidatorInterface $validator)
    {
        if (!isset($this->keysValues[$name])) {
            $this->keysValues[$name] = array();
        }
        $this->keysValues[$name][] = $validator;
        return $this;
    }

    public function isValid($values)
    {
        $this->setValue($values);
        $result = true;
        $messages = array();
        foreach ($this->keysValues as $name => $validators) {
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
}