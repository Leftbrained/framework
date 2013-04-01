<?php
namespace Leftbrained\StandardClass;

use Zend\Stdlib\ArrayUtils;
use Zend\Validator\ValidatorPluginManager;

class Definition implements DefinitionInterface
{
    protected static $validatorPluginManager;

    /**
     * 
     * @var PropertyInterface[]
     */
    protected $properties = array();
    protected $defaultInstanceOptions;
    protected $defaultPropertyValues = array();
    protected $messages = array();
    protected $readOnly;

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
        $this->readOnly = $options->getReadOnly();
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

    public function getInstanceOptions($options = null)
    {
        if (null === $options) {
            if (null === $this->defaultInstanceOptions) {
                $this->defaultInstanceOptions = new Options\InstanceOptions;
            }
            return $this->defaultInstanceOptions;
        }

        if (!$options instanceof Options\InstanceOptions) {
            if ($options instanceof Traversable) {
                $options = ArrayUtils::iteratorToArray($options);
            }
            if (!is_array($options)) {
                throw new Exception\InvalidArgumentException('invalid instance options, must be instanceof Traversible, InstanceOptions, or array');
            }
            $options = new Options\InstanceOptions($options);
        }

        return $options;
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

    public function isReadOnly()
    {
        return $this->readOnly;
    }

    public function isValid($values)
    {
        if ($values instanceof StandardClass) {
            $values = $values->toArray();
        } elseif (!is_array($values)) {
            throw new \Exception('InvalidArgument');
        }

        $result = true;
        $messages = array();
        foreach ($this->properties as $name => $property) {
            // Determine if property is required
            if (!isset($values[$name])) {
                $required = $property->isRequired();
                $message = 'Value is required';
                if (is_callable($required)) {
                    $required = $required($values);
                    if (is_string($required)) {
                        $message = $required;
                        $required = true;
                    } else {
                        $required = (boolean) $required;
                    }
                }
                if ($required) {
                    $result = false;
                    $messages[$name] = array(
                        'required' => $message,
                    );
                }
                continue;
            }

            $validator = $property->getValidator();
            if (null !== $validator && !$validator->isValid($values[$name])) {
                $result = false;
                $messages[$name] = array();
                foreach ($validator->getMessages() as $key => $message) {
                    $key = preg_replace(array('/([A-Z]+)([A-Z][a-z])/','/([a-z\d])([A-Z])/'), '$1_$2', $key);
                    $key = strtolower($key);
                    $messages[$name][$key] = $message;
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