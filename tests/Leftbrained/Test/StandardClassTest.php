<?php
namespace Leftbrained\Test;

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
}
