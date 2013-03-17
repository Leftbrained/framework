<?php
namespace Leftbrained\StandardClass;

interface DefinitionInterface
{
    /**
     * @return PropertyInterface[]
     */
    public function getProperties();
}