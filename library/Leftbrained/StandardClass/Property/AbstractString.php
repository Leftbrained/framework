<?php
namespace Leftbrained\StandardClass\Property;

use Leftbrained\StandardClass\Options\Property as Options;

abstract class AbstractString extends AbstractProperty
{
    protected function setOptions(Options\StringOptions $options)
    {
        parent::setOptions($options);
    }

    protected function castInternal($value)
    {
        return (string) $value;
    }
}