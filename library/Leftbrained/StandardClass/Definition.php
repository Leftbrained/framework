<?php
namespace Leftbrained\StandardClass;

use Zend\Validator\ValidatorChain;
use Zend\Stdlib\ArrayUtils;
use Leftbrained\StandardClass\Validator\ValidatorPluginManager;

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
            static::$validatorPluginManager = new ValidatorPluginManager();
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
        $propertyValidators = array();
        foreach ($this->properties as $property) {
            $propertyValidator = $property->getValidator();
            if (null !== $propertyValidator) {
                $propertyValidators[] = $propertyValidator;
            }
        }

        switch (count($propertyValidators)) {
            case 0:
                $propertyChain = null;
                break;
            case 1:
                $propertyChain = $propertyValidators[0];
                break;
            default: // count($propertyValidators) > 1
                $propertyChain = new ValidatorChain();
                foreach ($propertyValidators as $validator) {
                    $propertyChain->addValidator($validator);
                }
                break;
        }

        if (null !== $propertyChain) {
            array_unshift($validators, $propertyChain);
        }

        switch (count($validators)) {
            case 0:
                $this->validator = null;
                break;
            case 1:
                $this->validator = $validators[0];
                break;
            default: // count($validators) > 1
                $this->validator = new ValidatorChain();
                foreach ($validators as $validator) {
                    $this->validator->addValidator($validator);
                }
                break;
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

    public function isValid($instance)
    {
        if (null === $this->validator) {
            return true;
        }

        $this->validator->isValid($instance);
    }
}