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

    protected $definition;
    protected $data = array();

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
        $this->definition = static::getDefaultDefinition();
        $this->initializeProperties();

        if (null !== $array) {
            $this->loadArray($array);
        }
    }

    protected function initializeProperties()
    {
        $this->data = $this->definition->getDefaultPropertyValues();
    }

    public function get($name)
    {
        $property = $this->definition->getProperty($name);

        if (null === $property) {
            throw new Exception\InvalidArgumentException('Property "' . $name . '" is not defined');
        }

        return $this->data[$name];
    }

    public function set($name, $value)
    {
        $property = $this->definition->getProperty($name);

        if (null === $property) {
            throw new Exception\InvalidArgumentException('Property "' . $name . '" is not defined');
        }

        $this->data[$name] = $property->cast($value);

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
        return $this->data;
    }

    protected function loadArray(array $array)
    {
        foreach ($array as $name => $value) {
            $this->set($name, $value);
        }
    }

    public function validate()
    {
        if (!$this->definition->isValid($this)) {
            $messages = $this->definition->getMessages();
            $message = 'Invalid properties: ' . implode(array_keys($messages));
            $exception = new Exception\InvalidPropertiesException($message);
            $exception->setMessages($messages);

            throw $exception;
        }
    }
}