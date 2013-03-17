<?php
namespace Leftbrained\StandardClass;

use Zend\Stdlib\ArrayUtils;

class Definition implements DefinitionInterface
{
    /**
     * 
     * @var PropertyInterface[]
     */
    protected $properties = array();
    protected $defaultPropertyValues = array();

    public function __construct($options = array())
    {
        $this->setOptions($options);
    }

    protected function setOptions($options)
    {
        if (!$options instanceof Options\DefinitionOptions) {
            if ($options instanceof Traversable) {
                $options = ArrayUtils::iteratorToArray($options);
            }
            if (!is_array($options)) {
                throw new Exception\InvalidArgumentException('invalid definition options, must be instanceof Traversible, DefinitionOptions, or array');
            }
            $options = new Options\DefinitionOptions($options);
        }

        $this->initialize($options);
    }

    protected function initialize(Options\DefinitionOptions $options)
    {
        $this->initializeProperties($options->getProperties());
    }

    protected function initializeProperties(array $properties)
    {
        foreach ($properties as $options) {
            $class = $options->getClass();
            $property = new $class($options);
            $this->properties[$property->getName()] = $property;
            $this->defaultPropertyValues[$property->getName()] = $property->getDefaultValue();
        }
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function getProperty($name)
    {
        if (!isset($this->properties[$name])) {
            throw new Exception\InvalidArgumentException('Invalid property "' . $name . '"');
        }
        return $this->properties[$name];
    }

    public function getDefaultPropertyValues()
    {
        $this->defaultPropertyValues;
    }
}