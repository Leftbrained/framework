<?php
namespace Leftbrained\Test\StandardClass;

use PHPUnit_Framework_TestCase;
use Leftbrained\StandardClass\StandardClass;

class StandardClassTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function mustExist()
    {
        $instance = new StandardClass();
    }

    /**
     * @test
     */
    public function mustSetPropertyWithSetNameValue()
    {
        $instance = new StandardClass();
        $instance->set('my_name', 'VALUE');
    }

    /**
     * @test
     */
    public function mustSetThenGetSameStringWithMethods()
    {
        $instance = new StandardClass();
        $instance->set('my_name', 'm\'y %te%st! S(t"ri"n)g?');

        static::assertEquals('m\'y %te%st! S(t"ri"n)g?', $instance->get('my_name'));
    }
}
