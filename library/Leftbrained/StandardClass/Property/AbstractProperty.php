<?php
namespace Leftbrained\StandardClass\Property;

use Leftbrained\StandardClass\Options\Property as Options;
use Zend\Validator\ValidatorChain;

abstract class AbstractProperty implements PropertyInterface
{
    const CAST_TYPE_INTERNAL = 'internal';
    const CAST_TYPE_DEFAULT  = 'default';

    protected static $optionsClass = 'Leftbrained\\StandardClass\\Options\\Property\\AbstractPropertyOptions';

    /**
     * The property name (underscored and lower cased).
     * 
     * @var string
     */
    protected $name;

    /**
     * 
     * 
     * @var boolean
     */
    protected $required;

    /**
     * The default value for this property.
     * 
     * @var mixed
     */
    protected $defaultValue;

    /**
     * 
     * @var ValidatorInterface
     */
    protected $validator;

    public function __construct(Options\PropertyOptions $options)
    {
        $this->setOptions($options);
    }

    protected function setOptions(Options\PropertyOptions $options)
    {
        $this->name = $options->getName();
        $this->required = $options->getRequired();
        $this->defaultValue = $this->castInternal($options->getDefaultValue());

        $validators = $options->getValidators();

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

    public function getName()
    {
        return $this->name;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function getValidator()
    {
        return $this->validator;
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