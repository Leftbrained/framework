<?php
namespace Leftbrained\StandardClass;

use Zend\Validator\ValidatorChain;
use Zend\Stdlib\ArrayUtils;
use Leftbrained\Validator;

class Definition implements DefinitionInterface
{
    protected static $validatorPluginManager;

    /**
     * 
     * @var PropertyInterface[]
     */
    protected $properties = array();
    protected $defaultPropertyValues = array();
    protected $validator;

    public static function getValidatorPluginManager()
    {
        if (null === static::$validatorPluginManager) {
            static::$validatorPluginManager = new Validator\ValidatorPluginManager();
        }
        return static::$validatorPluginManager;
    }

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
        $this->initializeValidator($options->getValidators());
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

    protected function initializeValidator(array $validators = array())
    {
        $properties = null;
        foreach ($this->properties as $name => $property) {
            $validator = $property->getValidator();
            if (null !== $validator) {
                if (null === $properties) {
                    $properties = new Validator\KeyValues();
                }
                $properties->attach($name, $validator);
            }
        }

        if (empty($validators)) {
            $this->validator = $properties;
        } else {
            $this->validator = new Validator\ValidatorChain();

            $this->validator->attach($properties, true);
            foreach ($validators as $validator) {
                $this->validator->attach($validator);
            }
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
        return $this->defaultPropertyValues;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function isValid(StandardClass $instance)
    {
        if (null === $this->validator) {
            return true;
        }

        return $this->validator->isValid($instance->toArray());
    }

    public function getMessages()
    {
        if (null === $this->validator) {
            return array();
        }

        return $this->validator->getMessages();
    }
}