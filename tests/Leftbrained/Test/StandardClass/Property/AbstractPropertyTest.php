<?php
namespace Leftbrained\Test\StandardClass\Property;

use PHPUnit_Framework_TestCase;

class AbstractPropertyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function mustExist()
    {
        $property = $this->getAbstractProperty();
        static::assertInstanceOf('Leftbrained\\StandardClass\\Property\\AbstractProperty', $property);
    }

    /**
     * @test
     */
    public function mustSetName()
    {
        $property = $this->getAbstractProperty();
        $property->setName('my_name');
    }

    private function getAbstractProperty()
    {
        return static::getMockForAbstractClass('Leftbrained\\StandardClass\\Property\\AbstractProperty');
    }
}
