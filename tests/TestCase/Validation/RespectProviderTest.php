<?php

namespace Gourmet\Validation\Test\TestCase\Validation;

use Cake\TestSuite\TestCase;
use Gourmet\Validation\Validation\RespectProvider;
use Respect\Validation\Validator;

class RespectProviderTest extends TestCase
{
    public function setUp()
    {
        $this->provider = new RespectProvider();
    }

    public function tearDown()
    {
        unset($this->provider);
    }

    /**
     * @expectedException \Exception
     */
    public function testUndefinedMethod()
    {
        $this->provider->undefinedRule('');
    }

    /**
     * @expectedException \Gourmet\Validation\Error\UnsupportedMethodException
     * @expectedExceptionMessage Call to unsupported method [allOf]
     */
    public function testUnsupportedMethod()
    {
        $this->provider->allOf('');
    }

    public function testNot()
    {
        $this->assertTrue($this->provider->not(1, Validator::string()));
    }
}
