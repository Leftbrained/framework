<?php
namespace Leftbrained\Test\StandardClass\Property;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Leftbrained\StandardClass\Property\AbstractProperty;

class AbstractPropertyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function mustBeAbstract()
    {
        $class = $this->getAbstractPropertyReflection();
        static::assertTrue($class->isAbstract(), $class->getName() . ' must be abstract');
    }

    /**
     * @test
     */
    public function mustDefineAbstractMethodToDefault()
    {
        $class = $this->getAbstractPropertyReflection();
        $method = $class->getMethod('toDefault');
        static::assertTrue($method->isAbstract(), $method->getName() . ' must be abstract');
    }

    /**
     * @test
     */
    public function mustSetAndGetName()
    {
        $name = 'my_name';
        $property = $this->getAbstractPropertyMock();
        $property->setName($name);
        static::assertEquals($name, $property->getName());
    }

    /**
     * @return AbstractProperty
     */
    private function getAbstractPropertyMock()
    {
        return static::getMockForAbstractClass('Leftbrained\\StandardClass\\Property\\AbstractProperty');
    }

    /**
     * @return ReflectionClass
     */
    private function getAbstractPropertyReflection()
    {
        return new ReflectionClass('Leftbrained\\StandardClass\\Property\\AbstractProperty');
    }
}
