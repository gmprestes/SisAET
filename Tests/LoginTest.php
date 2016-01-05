<?php
class LoginTest extends PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $stack = array();
        //array_push($stack,1);
        $this->assertEmpty($stack);

        return $stack;
    }
  }
