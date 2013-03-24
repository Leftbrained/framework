<?php
namespace Leftbrained\Validator;

use Zend\Validator\ValidatorInterface;

class KeyValues extends AbstractValidatorMulti
{
    protected $keyValues = array();

    public function attach($name, ValidatorInterface $validator)
    {
        if (!isset($this->keyValues[$name])) {
            $this->keyValues[$name] = array();
        }
        $this->keyValues[$name][] = $validator;
        return $this;
    }

    public function isValid($values)
    {
        $this->setValue($values);
        $result = true;
        $messages = array();
        foreach ($this->keyValues as $name => $validators) {
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