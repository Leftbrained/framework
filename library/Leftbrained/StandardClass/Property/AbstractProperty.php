<?php
namespace Leftbrained\StandardClass\Property;

abstract class AbstractProperty
{
    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    abstract public function toDefault($value);
}
