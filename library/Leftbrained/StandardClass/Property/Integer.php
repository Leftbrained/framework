<?php
namespace Leftbrained\StandardClass\Property;

use Leftbrained\StandardClass\Options\Property as Options;

class Integer extends AbstractNumber
{

    protected function setOptions(Options\IntegerOptions $options)
    {
        parent::setOptions($options);
    }

    protected function castInternal($value)
    {
        return (integer) $value;
    }
}