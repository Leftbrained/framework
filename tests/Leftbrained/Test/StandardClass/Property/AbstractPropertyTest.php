<?php
namespace Leftbrained\Test\StandardClass\Property;

use PHPUnit_Framework_TestCase;
use Leftbrained\StandardClass\Property\Mixed as MixedProperty;

class AbstractPropertyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function mustExist()
    {
        $instance = static::getMockForAbstractClass('Leftbrained\\StandardClass\\Property\\AbstractProperty');
    }

    /**
     * @test
     */
    public function mustSetName()
    {
        $instance = static::getMockForAbstractClass('Leftbrained\\StandardClass\\Property\\AbstractProperty');
        $instance->setName('my_name');
    }
}
