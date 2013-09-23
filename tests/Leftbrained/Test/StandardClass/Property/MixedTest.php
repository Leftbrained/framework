<?php
namespace Leftbrained\Test\StandardClass\Property;

use PHPUnit_Framework_TestCase;
use Leftbrained\StandardClass\Property\Mixed as MixedProperty;

class MixedTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function mustExist()
    {
        $instance = new MixedProperty();
    }
}
