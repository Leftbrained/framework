<?php
namespace Leftbrained\Test\StandardClass;

use PHPUnit_Framework_TestCase;
use Leftbrained\StandardClass\Definition;

class DefinitionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function mustExist()
    {
        $instance = new Definition();
    }
}
