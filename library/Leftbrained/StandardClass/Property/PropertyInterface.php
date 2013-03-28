<?php
namespace Leftbrained\StandardClass\Property;

interface PropertyInterface
{
    public function getName();
    public function isRequired();
    public function getDefaultValue();
    public function getValidator();
}