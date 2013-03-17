<?php
namespace Leftbrained\StandardClass\Property;

use Leftbrained\StandardClass\Options\Property as Options;

abstract class AbstractNumber extends AbstractProperty
{
    protected $minimum;
    protected $maximum;

    protected function setOptions(Options\NumberOptions $options)
    {
        parent::setOptions($options);
        $this->minimum = $options->getMinimum();
        $this->maximum = $options->getMaximum();
    }
}