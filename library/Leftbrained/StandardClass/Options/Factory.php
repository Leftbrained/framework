<?php
namespace Leftbrained\StandardClass\Options;

use Leftbrained\StandardClass\Exception;
use Zend\Stdlib\ArrayUtils;

class Factory
{
    protected $properties = array(
        'mixed'         => 'Leftbrained\\StandardClass\\Options\\Property\\MixedOptions',
        'integer'         => 'Leftbrained\\StandardClass\\Options\\Property\\IntegerOptions',
    );

    public function getPropertyClass($type)
    {
        if (!isset($this->properties[$type])) {
            return null;
        }
        return $this->properties[$type];
    }

    public function createPropertyFromKeyValue($key, $value)
    {
        if ($value instanceof Traversable) {
            $value = ArrayUtils::iteratorToArray($value);
        }

        if (is_array($value)) {
            $options = $value;
        } elseif (is_string($value)) {
            $options = array(
                'type' => $value,
            );
        } else {
            throw new Exception\InvalidArgumentException('invalid property options for "' . $key . '"');
        }

        if (is_string($key)) {
            $options['name'] = $key;
        }

        return $this->createProperty($options);
    }

    public function createProperty($options)
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        }
        if (!is_array($options)) {
            throw new Exception\InvalidArgumentException('invalid property options, must be array or instanceof Traversible');
        }

        if (isset($options['type'])) {
            $type = $options['type'];
            unset($options['type']);
        } else {
            $type = 'mixed';
        }

        $class = $this->getPropertyClass($type);

        if (null === $class) {
            throw new Exception\RuntimeException('Undefined property type: "' . $type . '"');
        }

        return new $class($options);
    }
}