<?php
namespace Leftbrained\Test\StandardClass\Property;

use PHPUnit_Framework_TestCase;
use Leftbrained\StandardClass\Property\Mixed as MixedProperty;
use ReflectionClass;
use Leftbrained\StandardClass\Property\AbstractProperty;

class MixedTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function mustExist()
    {
        $instance = new MixedProperty();
    }

    /**
     * @test
     */
    public function mustExtendAbstractProperty()
    {
        $class = $this->getMixedReflection();
        $parent = $class->getParentClass();
        static::assertEquals('Leftbrained\\StandardClass\\Property\\AbstractProperty', $parent ? $parent->getName() : null);
    }

    /**
     * @return ReflectionClass
     */
    private function getMixedReflection()
    {
        return new ReflectionClass('Leftbrained\\StandardClass\\Property\\Mixed');
    }
}
