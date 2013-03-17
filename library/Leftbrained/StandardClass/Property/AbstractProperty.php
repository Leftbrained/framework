<?php
namespace Leftbrained\StandardClass\Property;

use Leftbrained\StandardClass\Options\Property as Options;

abstract class AbstractProperty implements PropertyInterface
{
    const CAST_TYPE_INTERNAL = 'internal';
    const CAST_TYPE_DEFAULT  = 'default';

    /**
     * The property name (underscored and lower cased).
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

    public function __construct($options)
    {
        $this->setOptions($options);
    }

    protected function setOptions($options)
    {
        if (!$options instanceof Options\AbstractPropertyOptions) {
            if ($options instanceof Traversable) {
                $options = ArrayUtils::iteratorToArray($options);
            }
            if (!is_array($options)) {
                throw new Exception\InvalidArgumentException('invalid property options, must be instanceof Traversible, AbstractPropertyOptions, or array');
            }
            $options = new Options\AbstractPropertyOptions($options);
        }

        // initialize options
        $this->name = $options->getName();
        $this->defaultValue = $this->castInternal($options->getDefaultValue());
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /*
     * Converts $value into the internal representation.
     *
     * It will always return the proper type, and never throw an exception.
     *
     * @param $value mixed
     * @return mixed
     */
    abstract protected function castInternal($value);

    protected function castDefault($value)
    {
        return $this->castInternal($value);
    }

    public function cast($value, $type = self::CAST_TYPE_DEFAULT)
    {
        if (null === $value) {
            return $value;
        }

        $value = $this->castInternal($value);
        switch ($type) {
            case static::CAST_TYPE_DEFAULT:
                return $this->castDefault($value);
            case static::CAST_TYPE_INTERNAL:
                return $value;
            default:
                throw new InvalidArgumentException('Invalid cast type "' . $type . '"');
        }
    }
}