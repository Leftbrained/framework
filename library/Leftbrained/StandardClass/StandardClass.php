<?php
namespace Leftbrained\StandardClass;

class StandardClass
{
    protected $_properties = array();

    public function set($name, $value)
    {
        $this->_properties[$name] = $value;
    }

    public function get($name)
    {
        return $this->_properties[$name];
    }
}
