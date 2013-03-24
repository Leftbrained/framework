<?php
namespace Leftbrained\StandardClass\Exception;

class InvalidPropertiesException extends \RangeException implements
    ExceptionInterface
{
    protected $messages = array();

    public function setMessages(array $messages)
    {
        $this->messages = $messages;
        return $this;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
