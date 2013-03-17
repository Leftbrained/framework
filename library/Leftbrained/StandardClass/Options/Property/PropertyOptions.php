<?php
namespace Leftbrained\StandardClass\Options\Property;

use Leftbrained\Stdlib\AbstractOptions;

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
     * The default value for this property.
     *
     * @var mixed
     */
    protected $defaultValue = null;

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

    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
}