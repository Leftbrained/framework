<?php
namespace Leftbrained\StandardClass\Options;

use Leftbrained\Stdlib\AbstractOptions;
use Leftbrained\StandardClass\Exception;
use Leftbrained\StandardClass\Options\Property\AbstractPropertyOptions;

class DefinitionOptions extends AbstractOptions
{
    /**
     * 
     * @var Factory
     */
    protected static $factory;

    /**
     * The class name
     *
     * @var string
     */
    protected $class;

    /**
     * The defined properties.
     *
     * @var AbstractPropertyOptions[]
     */
    protected $properties = array();

//     /**
//      * Whether or not adding undefined properties will be allowed.
//      *
//      * @var boolean
//      */
//     protected $allowCustomProperties = true;

    /**
     * @return Factory
     */
    protected static function getFactory()
    {
        if (null === static::$factory) {
            static::$factory = new Factory();
        }
        return static::$factory;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties($properties)
    {
        if (!is_array($properties)) {
            throw new Exception\InvalidArgumentException('properties must be an array');
        }

        $this->properties = array();

        $factory = static::getFactory();
        foreach ($properties as $key => $value) {
            $this->properties[] = $factory->createPropertyFromKeyValue($key, $value);
        }
        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

//     public function getAllowCustomProperties()
//     {
//         return $this->allowCustomProperties;
//     }

//     public function setAllowCustomProperties($allowCustomProperties)
//     {
//         $this->allowCustomProperties = (boolean)$allowCustomProperties;
//         return $this;
//     }
}