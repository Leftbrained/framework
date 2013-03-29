<?php
namespace Leftbrained\StandardClass\Property;

use Leftbrained\StandardClass\Options\Property as Options;

class Float extends AbstractNumber
{

    protected function setOptions(Options\FloatOptions $options)
    {
        parent::setOptions($options);
    }

    protected function castInternal($value)
    {
        return (float) $value;
    }
}