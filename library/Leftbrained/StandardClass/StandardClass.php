<?php
namespace Leftbrained\StandardClass;

class StandardClass
{
    protected static $definitionOptions = array();

    /**
     * 
     * @var Definition[class]
     */
    protected static $defaultDefinitions = array();

    /**
     * 
     * @var Definition
     */
    protected $_definition;

    /**
     * 
     * 
     * @var mixed[string]
     */
    protected $_data = array();

    /**
     * 
     * @var boolean
     */
    protected $_verifyReadOnly = false;

    public static function fromArray(array $array)
    {
        return new static($array);
    }

    /**
     * @return Definition
     */
    public static function getDefaultDefinition()
    {
        $class = get_called_class();

        if (!isset(self::$defaultDefinitions[$class])) {
            self::$defaultDefinitions[$class] = static::initializeDefinition();
        }

        return self::$defaultDefinitions[$class];
    }

    public static function initializeDefinition()
    {
        return new Definition(static::$definitionOptions);
    }

    public function __construct(array $array = null)
    {
        $this->_definition = static::getDefaultDefinition();
        $this->initializeProperties();

        if (null !== $array) {
            $this->loadArray($array);
        }
        $this->_verifyReadOnly = true;
    }

    protected function initializeProperties()
    {
        $this->_data = $this->_definition->getDefaultPropertyValues();
    }

    public function get($name)
    {
        $property = $this->_definition->getProperty($name);

        if (null === $property) {
            throw new Exception\InvalidArgumentException('Property "' . $name . '" is not defined');
        }

        return $this->_data[$name];
    }

    public function set($name, $value)
    {
        $property = $this->_definition->getProperty($name);

        if (null === $property) {
            throw new Exception\InvalidArgumentException('Property "' . $name . '" is not defined');
        }

        if ($this->_verifyReadOnly) {
            if ($this->_definition->isReadOnly()) {
                throw new Exception\InvalidArgumentException('Class "' . get_class($this) . '" is read only');
            }
        }

        $this->_data[$name] = $property->cast($value);

        return $this;
    }

    public function __get($name)
    {
        $name = preg_replace(array('/([A-Z]+)([A-Z][a-z])/','/([a-z\d])([A-Z])/'), '$1_$2', $name);
        $name = strtolower($name);

        return $this->get($name);
    }

    public function __set($name, $value)
    {
        $name = preg_replace(array('/([A-Z]+)([A-Z][a-z])/','/([a-z\d])([A-Z])/'), '$1_$2', $name);
        $name = strtolower($name);

        $this->set($name, $value);
    }

    public function toArray()
    {
        return $this->_data;
    }

    protected function loadArray(array $array)
    {
        foreach ($array as $name => $value) {
            $this->set($name, $value);
        }
    }

    public function validate()
    {
        if (!$this->_definition->isValid($this)) {
            $messages = $this->_definition->getMessages();
            $message = 'Invalid properties: ' . implode(array_keys($messages));
            $exception = new Exception\InvalidPropertiesException($message);
            $exception->setMessages($messages);

            throw $exception;
        }
    }
}