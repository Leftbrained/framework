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
        $instance = $this->getMixedDefaultInstance();
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
     * @test
     */
    public function castDefaultMustNotAlterValue()
    {
        $this->assertCast('This IS a string %s value ?');
        $this->assertCast(-983);
        $this->assertCast(3.14159);
        $this->assertCast(array('fred', 12, 'wilma'));
        $this->assertCast(new \stdClass());
    }

    private function assertCast($value)
    {
        $instance = $this->getMixedDefaultInstance();
        static::assertEquals($value, $instance->castDefault($value));
    }

    /**
     * @return MixedProperty
     */
    private function getMixedDefaultInstance()
    {
        return new MixedProperty();
    }

    /**
     * @return ReflectionClass
     */
    private function getMixedReflection()
    {
        return new ReflectionClass('Leftbrained\\StandardClass\\Property\\Mixed');
    }
}
