<?php
namespace Leftbrained\StandardClass\Property;

class Mixed extends AbstractProperty
{
    public function castDefault($value)
    {
        return $value;
    }
}
