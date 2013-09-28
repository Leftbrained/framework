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
        $className = 'Leftbrained\\StandardClass\\Property\\AbstractProperty';
        $class = new ReflectionClass($className);
        static::assertTrue($class->isAbstract(), $className . ' must be abstract');
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
