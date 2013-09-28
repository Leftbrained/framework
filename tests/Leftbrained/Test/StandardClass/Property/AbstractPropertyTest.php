<?php
namespace Leftbrained\Test\StandardClass\Property;

use PHPUnit_Framework_TestCase;
use Leftbrained\StandardClass\Property\AbstractProperty;

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
    public function mustSetAndGetName()
    {
        $name = 'my_name';
        $property = $this->getAbstractProperty();
        $property->setName($name);
        static::assertEquals($name, $property->getName());
    }

    /**
     * @return AbstractProperty
     */
    private function getAbstractProperty()
    {
        return static::getMockForAbstractClass('Leftbrained\\StandardClass\\Property\\AbstractProperty');
    }
}
