<?php
namespace Leftbrained\StandardClass\Options\Property;

use Leftbrained\StandardClass\Exception;
use Leftbrained\StandardClass\Definition;
use Leftbrained\Stdlib\AbstractOptions;
use Zend\Validator\ValidatorInterface;

class PropertyOptions extends AbstractOptions
{
    protected $class = 'Leftbrained\\StandardClass\\Property\\Mixed';

    /**
     * The property name (underscored)
     *
     * @var string
     */
    protected $name;

    /**
     * 
     * 
     * @var boolean
     */
    protected $required = false;

    /**
     * The default value for this property.
     *
     * @var mixed
     */
    protected $defaultValue = null;

    /**
     * 
     * @var mixed[mixed]
     */
    protected $aliases;

    /**
     * 
     * @var ValidatorInterface[]
     */
    protected $validators = array();

    public function getClass()
    {
        return $this->class;
    }

    public function setName($name)
    {
        $this->name = (string)$name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function setRequired($required)
    {
        $this->required = (boolean) $required;
        return $this;
    }

    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    public function setAliases($aliases)
    {
        if (!is_array($aliases)) {
            throw new Exception\InvalidArgumentException('aliases must be an array');
        }

        $this->aliases = $aliases;
        return $this;
    }

    public function setValidators($validators)
    {
        if (!is_array($validators)) {
            throw new Exception\InvalidArgumentException('validators must be an array');
        }

        $this->validators = array();

        $pluginManager = Definition::getValidatorPluginManager();

        foreach ($validators as $key => $value) {
            if (!is_string($key)) {
                throw new Exception\InvalidArgumentException('validator key must be the validator name');
            }

            $this->validators[] = $pluginManager->get($key, $value);
        }
        return $this;
    }

    public function getValidators()
    {
        return $this->validators;
    }
}