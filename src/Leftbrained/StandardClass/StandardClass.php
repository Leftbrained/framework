<?php
namespace Leftbrained\StandardClass;

class StandardClass
{
    /**
     * 
     * @var Definition
     */
    protected static $definition;

    protected $data = array();

    public static function fromArray(array $array)
    {
        return new static($array);
    }

    /**
     * @return Definition
     */
    public static function getDefinition()
    {
        if (null === static::$definition) {
            static::$definition = new StandardDefinition();
        }
        return static::$definition;
    }

    public function __construct(array $array = null)
    {
        $this->initializeProperties();

        if (null !== $array) {
            $this->loadArray($array);
        }
    }

    protected function initializeProperties()
    {
        foreach (static::getDefinition()->getProperties() as $property) {
            $this->initializeProperty();
        }
    }

    protected function initializeProperty(PropertyInterface $property)
    {
        $this->data[$property->getKey()] = $property->getDefaultValue();
    }

    public function get($property)
    {
        
    }

    public function toArray()
    {
        return $this->data;
    }

    protected function loadArray(array $array)
    {
        
    }
}