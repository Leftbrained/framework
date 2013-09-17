<?php
namespace Leftbrained\Test;

use PHPUnit_Framework_TestCase;
use Leftbrained\StandardClass\StandardClass;

class StandardClassTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function classStandardClassMustExist()
    {
        $obj = new StandardClass();
    }
}