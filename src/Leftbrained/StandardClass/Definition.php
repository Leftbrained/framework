<?php
namespace Leftbrained\StandardClass;

class Definition implements DefinitionInterface
{
    /**
     * 
     * @var PropertyInterface[]
     */
    protected $properties = array();

    public function __construct($options)
    {
        
    }

    public function getProperties()
    {
        return $this->properties;
    }
}