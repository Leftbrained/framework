<?php
namespace Leftbrained\StandardClass\Options;

use Leftbrained\Stdlib\AbstractOptions;

class InstanceOptions extends AbstractOptions
{
    /**
     * 
     * @var boolean
     */
    protected $readOnly = false;

    public function getReadOnly()
    {
        return $this->readOnly;
    }

    public function setReadOnly($readOnly)
    {
        $this->readOnly = (boolean)$readOnly;
        return $this;
    }
}