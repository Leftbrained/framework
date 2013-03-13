<?php
namespace Leftbrained\StandardClass;

class StandardClass
{
    protected $data = array();

    public static function fromArray(array $array)
    {
        return new static($array);
    }

    public function __construct(array $array = null)
    {
        if (null !== $array) {
            $this->loadArray($array);
        }
    }

    protected function loadArray(array $array)
    {
        
    }
}