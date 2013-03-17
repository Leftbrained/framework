<?php
namespace Leftbrained\StandardClass\Options\Property;

class NumberOptions extends PropertyOptions
{
    /**
     * The minimum value.
     *
     * @var integer
     */
    protected $minimum;

    /**
     * The maximum value.
     *
     * @var integer
     */
    protected $maximum;

    public function getMinimum()
    {
        return $this->minimum;
    }

    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;
        return $this;
    }

    public function getMaximum()
    {
        return $this->maximum;
    }

    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;
        return $this;
    }
}