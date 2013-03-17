<?php
namespace Leftbrained\StandardClass\Property;

class Mixed extends AbstractProperty
{
    public function castInternal($value)
    {
        return $value;
    }
}